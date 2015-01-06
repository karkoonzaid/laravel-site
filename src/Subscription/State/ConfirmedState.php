<?php
namespace Acme\Subscription\State;

class ConfirmedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'CONFIRMED';
        $this->subscriber->model->save();

        // update available seats .. find the function in EventModel
        $this->subscriber->model->event->setting->updateAvailableSeats($this->subscriber->model->registration_type);
        return $this;
    }

}