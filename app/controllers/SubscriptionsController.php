<?php

use Acme\EventModel\EventRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\State\Subscriber;
use Acme\Subscription\SubscriptionRepository;

class SubscriptionsController extends BaseController {

    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * @var Acme\EventModel\EventRepository
     */
    private $eventRepository;
    /**
     * @var Acme\Package\PackageRepository
     */

    private $packageRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository, EventRepository $eventRepository, PackageRepository $packageRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->eventRepository        = $eventRepository;
        $this->packageRepository      = $packageRepository;
        $this->beforeFilter('auth', ['only' => ['subscribe', 'unsubscribe', 'subscribePackage']]);
        parent::__construct();
    }

    /**
     * @param string $eventId
     * @param string $registrationType
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     * Accessed through post form request
     */
    public function subscribe($eventId = '', $registrationType = '')
    {
        $userId           = Auth::user()->id;
        $eventId          = empty($eventId) ? Input::get('event_id') : $eventId;
        $registrationType = empty($registrationType) ? Input::get('registration_type') : $registrationType;
        $subscription     = $this->subscriptionRepository->findByEvent($userId, $eventId);
        $event            = $this->eventRepository->findById($eventId);

        // If not a valid event
        if ( !$event ) {

            return Redirect::action('EventsController@show', $eventId)->with('warning', trans('word.system_error'));
        }

        // if event is currently going on
//        if ( $this->eventRepository->ongoingEvent($event->date_start, $event->date_end) ) {
//
//            return Redirect::action('EventsController@show', $eventId)->with('warning', trans('general.event_ongoing'));
//        }

        // If event is Expired
//        if ( $this->eventRepository->eventExpired($event->date_start) ) {
//
//            return Redirect::action('EventsController@show', $eventId)->with('warning', trans('word.event_expired'));
//        }

        // If no subscription entry in the database
        if ( !$subscription ) {
            // create a subscription
            $subscription = $this->subscriptionRepository->create(['user_id' => $userId, 'event_id' => $eventId, 'status' => 'PENDING', 'registration_type' => $registrationType]);
        }

        // Subscribe the user to the event
        $subscriber = new Subscriber($subscription);
        $subscriber = $subscriber->subscribe();

        if ( $subscriber->messages->has('errors') ) {
            // redirect with first error as an array
            return Redirect::home()->with('errors', [$subscriber->messages->first('errors')]);
        } else {
            // If no errors occured while subscription process
            return Redirect::action('EventsController@getSuggestedEvents', $eventId)->with('success', trans('general.subscription_check_email'));
        }
    }

    /**
     * @param $eventId EventID
     * @return \Illuminate\Http\RedirectResponse
     * Unsubscribe a user
     */
    public function unsubscribe($eventId)
    {
        $userId       = Auth::user()->id;
        $event        = $this->eventRepository->findById($eventId);
        $subscription = $this->subscriptionRepository->findByEvent($userId, $eventId);

        if ( !$event ) {

            return Redirect::action('EventsController@show', $eventId)->with('warning', trans('word.system_error'));
        }

        // If event is Expired
        if ( $this->eventRepository->eventExpired($event->date_start) ) {

            return Redirect::action('EventsController@show', $eventId)->with('warning', trans('word.event_expired'));
        }

        // if event is currently going on
//        if ( $this->eventRepository->ongoingEvent($event->date_start, $event->date_end) ) {
//
//            return Redirect::action('EventsController@show', $eventId)->with('warning', trans('general.event_ongoing'));
//        }

        if ( $subscription ) {

            $subscriber = new Subscriber($subscription);
            $subscriber = $subscriber->unsubscribe();

            if ( $subscriber->messages->has('errors') ) {
                // redirect with first error as an array
                return Redirect::action('EventsController@index')->with('errors', [$subscriber->messages->first('errors')]);
            } else {
                // If no errors occured while subscription process
                return Redirect::action('EventsController@index')->with('success', trans('general.unsubscribed'));
            }

        }

        return Redirect::action('EventsController@index')->with('success', trans('general.subscription.unsubscribed_fail'));
    }

    public function subscribePackage($userId = 1, $packageId = 1)
    {
        // loop through packages each events and subscribe
        $package = $this->packageRepository->findById($packageId);

        foreach ( $package->events as $event ) {
            $this->subscribe($userId, $event->id);
        }

    }

    /**
     * @param $eventId
     * Confirm the Subscription after click email link
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmSubscription($eventId)
    {
        $subscription = $this->subscriptionRepository->findByEvent(Auth::user()->id, $eventId);

        if ( $subscription ) {
            return $this->subscribe($eventId, $subscription->registration_type);
        }

        return Redirect::action('EventsController@index')->with('error', trans('general.error'));

    }
}

