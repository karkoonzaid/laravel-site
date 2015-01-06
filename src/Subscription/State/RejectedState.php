<?php
namespace Acme\Subscription\State;

class RejectedState extends AbstractState implements SubscriberState {


    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->messages->add('errors', trans('general.subscription_error'));
        return $this;
    }

}