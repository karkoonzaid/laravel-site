<?php
namespace Acme\Subscription\State;

class ApprovedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        // 1 - Find if any seats are available to register the user
        if ( !$this->subscriber->model->event->setting->hasAvailableSeats($this->subscriber->model->registration_type) ) {

            // If No Seats Available, Set user status to Waiting List
            $this->subscriber->messages->add('errors', 'No Seats Available');

            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        // check whether already subscribed
        if ( !$this->subscriber->model->subscriptionConfirmed() ) {

            if ( $this->checkInvalidRegistrationType() ) {
                // @todo : more efficient way to determine the free or paid event
                if ( $this->subscriber->model->event->isFreeEvent() ) {
                    // Free Event
                    return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());
                } else {
                    // Paid Event
                    return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
                }
            }
        } else {
            return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
        }

    }
//    public function createSubscription()
//    {
//        // 1 - Find if any seats are available to register the user
//        if ( !$this->subscriber->model->event->hasAvailableSeats() ) {
//
//            // If No Seats Available, Set user status to Waiting List
//            $this->subscriber->messages->add('errors', 'No Seats Available');
//
//            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
//        }
//
//        // check whether already subscribed
//        if ( !$this->subscriber->model->subscriptionConfirmed() ) {
//
//            if ( $this->checkInvalidRegistrationType() ) {
//                // @todo : more efficient way to determine the free or paid event
//                if ( $this->subscriber->model->event->isFreeEvent() ) {
//                    // Free Event
//                    return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());
//                } else {
//                    // Paid Event
//                    return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
//                }
//            }
//        } else {
//            return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
//        }
//
//    }

    /**
     * Check If the User Registration Type is in the available option of the Event's Registration System
     */
    private function checkInvalidRegistrationType()
    {
        $available_registration_types = $this->subscriber->model->event->setting->registration_types;
        $available_registration_types = explode(',', $available_registration_types);

        if ( !in_array($this->subscriber->model->registration_type, $available_registration_types) ) {

            $this->subscriber->messages->add('errors', 'Option not available');

            return false;
        }

        return true;
    }


}