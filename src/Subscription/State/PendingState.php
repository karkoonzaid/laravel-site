<?php
namespace Acme\Subscription\State;

class PendingState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'PENDING';
        $this->subscriber->model->save();
        return $this;
    }

}