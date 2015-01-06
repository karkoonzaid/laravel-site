<?php namespace Acme\Subscription\State\Admin;

use Acme\Subscription\State\AbstractState;
use Acme\Subscription\State\SubscriberState;

class ApprovedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {

        if ( !$this->subscriber->model->event->setting->hasAvailableSeats($this->subscriber->model->registration_type) ) {
            // If No Seats Available, Set user status to Waiting List
            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        if ( $this->subscriber->model->event->isFreeEvent() ) {

            // Free Event
            if ( $this->subscriber->model->event->setting->approval_type == 'CONFIRM' ) {

                $this->subscriber->model->status = 'APPROVED';
                $this->subscriber->model->save();

            } else {

                return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());

            }
        } else {
            // Paid Event
            return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
        }

    }


}