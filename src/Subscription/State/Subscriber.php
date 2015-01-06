<?php namespace Acme\Subscription\State;

use Acme\Core\Exceptions\InvalidClassPropertyException;
use App;
use Event;
use Illuminate\Support\MessageBag;
use Subscription;

class Subscriber {

    public $confirmed;
    public $approved;
    public $waiting;
    public $rejected;
    public $pending;
    public $payment;
    public $model;
    public $subscriptionState;
    public $messages;
    public $cancelled;

    public function __construct(Subscription $subscription)
    {
        // Set the class properties to their respective classes
        $this->confirmed = new ConfirmedState($this);
        $this->waiting   = new WaitingState($this);
        $this->rejected  = new RejectedState($this);
        $this->pending   = new PendingState($this);
        $this->messages  = new MessageBag();
        $this->approved  = new ApprovedState($this);
        $this->payment   = new PaymentState($this);
        $this->cancelled = new CancelledState($this);

        $this->model = $subscription;

        // If the Status is not empty, Asssign the respective status that is retrieved from the database
        $status = strtolower($this->model->status);

        if ( !(property_exists($this, $status)) ) {
            throw new InvalidClassPropertyException;
        }

        $this->subscriptionState = $this->{$status};

        // add the current status to the Message Bag  ( stores the value of status in the session )
        $this->messages->add('status', $status);
    }

    /**
     * @param $newSubscriptionState
     * Set SubscriptionState to whatever Argument Passed on the run time
     */
    public function setSubscriptionState($newSubscriptionState)
    {
        $this->subscriptionState = $newSubscriptionState;
        $this->subscribe();
    }

    /**
     * @param $newUnSubscriptionState
     * @internal param $newSubscriptionState Set SubscriptionState to whatever Argument Passed on the run time* Set SubscriptionState to whatever Argument Passed on the run time
     */
    public function setUnSubscriptionState($newUnSubscriptionState)
    {
        $this->subscriptionState = $newUnSubscriptionState;
        $this->unsubscribe();
    }

    /**
     * Create Subscription for the current subscription state
     */
    public function subscribe()
    {
        // Create Subscription method is available in all the classes that implements the SubscriberState Interface ( ex: ApprovedState )
        $this->subscriptionState->createSubscription();

        if ( !$this->messages->has('errors') ) {
            $this->notifyUser();
        }

        return $this;
    }

    /**
     * cancel the subcription of the user
     */
    public function unsubscribe()
    {
        $this->subscriptionState->cancelSubscription();

        return $this;
    }

    /**
     * @return ConfirmedState
     */
    public function getConfirmedState()
    {
        return $this->confirmed;
    }

    /**
     * @return \Acme\Subscription\State\Approved
     */
    public function getApprovedState()
    {
        return $this->approved;
    }

    /**
     * @return \Acme\Subscription\State\Waiting
     */
    public function getWaitingState()
    {
        return $this->waiting;
    }

    /**
     * @return \Acme\Subscription\State\Rejected
     */
    public function getRejectedState()
    {
        return $this->rejected;
    }

    /**
     * @return \Acme\Subscription\State\Pending
     */
    public function  getPendingState()
    {
        return $this->pending;
    }

    /**
     * @return \Acme\Subscription\State\Payment
     */
    public function  getPaymentState()
    {
        return $this->payment;
    }

    /**
     * @return mixed
     */
    public function getCancelledState()
    {
        return $this->cancelled;
    }

    public function notifyUser()
    {
        // Pass the User and Event Model, and Merge both into one array and pass it to the Event Fired
        $user  = $this->model->user->toArray();
        $event = $this->model->event;

        // payment token;
        $token  = $this->messages->has('token') ? $this->messages->get('token') : [''];
        $reason = $this->messages->has('reason') ? $this->messages->get('reason') : [''];

        // Merge User and Event Model
        $user = array_merge($user, ['title' => $event->title, 'event_id' => $event->id, 'status' => $this->model->status, 'token' => array_shift($token), 'reason' => array_shift($reason)]);
        // Fire the Event ( this will also send email to the user )
//        if ( App::environment() == 'local' ) return true;

        Event::fire('subscriptions.created', [$user]);

    }


}