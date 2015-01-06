<?php

use Acme\Country\CountryRepository;
use Acme\EventModel\EventRepository;
use Acme\Libraries\UserCurrency;
use Acme\Payment\Methods\Paypal;
use Acme\Payment\PaymentRepository;
use Acme\Subscription\SubscriptionRepository;

class PaymentsController extends BaseController {

    /**
     * Post Model
     */
    protected $model;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var UserCurrency
     */
    private $converter;

    private $defaultCurrency = 'USD';
    /**
     * @var Paypal
     */
    private $paypal;
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * Inject the models.
     * @param PaymentRepository $paymentRepository
     * @param EventRepository $eventRepository
     * @param UserCurrency $converter
     * @param Paypal $paypal
     * @param CountryRepository $countryRepository
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(PaymentRepository $paymentRepository, EventRepository $eventRepository, UserCurrency $converter, Paypal $paypal, CountryRepository $countryRepository, SubscriptionRepository $subscriptionRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->eventRepository   = $eventRepository;
        $this->converter         = $converter;
        $this->paypal            = $paypal;
        $this->beforeFilter('auth');
        parent::__construct();
        $this->countryRepository      = $countryRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @param $id
     * Lands on this page when link from email is clicked
     */
    public function getPayment($id)
    {
        $payment = $this->paymentRepository->findByToken(Input::get('token'));
        if ( !$payment ) {
            return Redirect::action('EventsController@index')->with('error', trans('word.token_expired'));
        }

        $event = $this->eventRepository->findById($id);
        if ( $this->eventRepository->eventExpired($event->date_start) ) {
            return Redirect::action('EventsController@index')->with('error', trans('word.event_expired'));
        }

        $user = Auth::user();

        $country = $this->processCountry($event);
        $subscription = $this->subscriptionRepository->findByEvent($user->id, $event->id);
        $eventPrice   = $event->getPriceByCountryAndType($country->id, $subscription->registration_type)->first();

        $this->render('site.events.payment-options', compact('event', 'payment', 'country', 'eventPrice', 'country'));
    }

    public function postPayment()
    {
        $payableId = Input::get('event_id');

        $token = Input::get('token'); // payment token

        $paymentRepo = $this->paymentRepository->findByToken($token);

        $paymentRepo->method = 'paypal';

        $event = $this->eventRepository->findById($payableId);

        $country      = $this->processCountry($event);

        $user = Auth::user();

        $subscription = $this->subscriptionRepository->findByEvent($user->id, $event->id);

        $eventPrice = $event->getPriceByCountryAndType($country->id,$subscription->registration_type)->first();

        $convertedPrice = $this->converter->convert($this->defaultCurrency, $eventPrice->price);

        if ( $convertedPrice <= 0 ) {
            return Redirect::back('/')->with('error', trans('word.system_error'));
        }

        $paymentRepo->amount = $convertedPrice;

        $paymentRepo->currency = $this->defaultCurrency;

        $description = 'Total: ' . $convertedPrice . ' ' . $this->defaultCurrency . '. ';
        $description .= Str::limit(strip_tags($event->description), 50, '..');

        $baseUrl = App::make('url')->action('PaymentsController@getFinal') . '?t=' . $token;

        $item = ['title' => $event->title, 'amount' => $paymentRepo->amount, 'description' => $event->description];

        try {
            // Instantiate Paypal Class
            $payer = $this->paypal;

            // Make Payment
            $payment = $payer->makePayment($paymentRepo->amount, 'USD', $description, "$baseUrl&success=true", "$baseUrl&success=false", $item);

            $paymentRepo->status = 'CREATED';

            $paymentRepo->transaction_id = $payment->getId();

            $paymentRepo->save();

            // Redirect With Payment Params
            header("Location: " . $this->getLink($payment->getLinks(), 'approval_url'));

            exit;

        }

        catch ( Exception $e ) {

            // Set Status To Error
            $paymentRepo->status = 'ERROR';

            $paymentRepo->save();

            return Redirect::back()->with('info', trans('word.system_error'));
        }

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * Lands to this page right after the Payment Process
     */
    public function getFinal()
    {
        $token = Input::get('t'); // site generated token

        $payment = $this->paymentRepository->findByToken($token);

        if ( !$payment ) {

            return Redirect::action('EventsController@index')->with('error', trans('word.invalid_token'));
        }

        $payment->payer_id      = Input::get('PayerID');
        $payment->payment_token = Input::get('token'); // token from the payment vendor

        if ( Input::get('success') == true ) {

            $payer = new Paypal();

            $payer->executePayment($payment->transaction_id, $payment->payer_id);

            $payment->status = 'CONFIRMED';
            $payment->token  = ''; // set token to null
            $payment->save();

            // Subscribe the User
            $controller = App::make('SubscriptionsController');

            // Get The Event to Pass to the Subscription Function
            $event = $payment->payable->event;
            $controller->callAction('subscribe', [$event->id, 'PAYMENT']); //todo pass the event ID

            return Redirect::action('EventsController@getSuggestedEvents', $event->id)->with('success', trans('general.subscribed'));

        }
        // If Transaction Failed
        $payment->status = 'REJECTED';
        $payment->save();

        return Redirect::action('EventsController@index')->with('error', trans('general.subscription_error'));
    }

    public function getLink(array $links, $type)
    {
        foreach ( $links as $link ) {
            if ( $link->getRel() == $type ) {
                return $link->getHref();
            }
        }

        return "";
    }

    /**
     * @param $event
     * @return mixed
     */
    public function processCountry($event)
    {
        // Get The Country of User Stored in Session or DB

        $country = $this->countryRepository->model->where('iso_code', Session::get('user.country'))->first();

        // Get All the Countries that this Event is attached to and convert it into array
        $eventCountries = $event->eventPrices->unique()->implode('id', ',');

        // If the user's Country is Not In the Attached Countries of the Event, then set the country as Default Country
        if ( !in_array($country->id, explode(',', $eventCountries)) ) {

            $defaultCountry = $this->countryRepository->defaultCountry;

            $country = $this->countryRepository->model->where('iso_code', $defaultCountry)->first();

            return $country;
        }

        return $country;
    }
}