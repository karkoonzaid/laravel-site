<?php
namespace Acme\Subscription\State;

class WaitingState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->messages->add('errors', 'Sorry, Seats are full. Subscription have been put on waiting list');
        $this->subscriber->model->status = 'WAITING';
        $this->subscriber->model->save();
        return $this;
    }

}