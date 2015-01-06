<?php
namespace Acme\Subscription\State;

use Auth;

class CancelledState extends AbstractState implements SubscriberState {


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

    /**
     * @return $this
     * Cancel the Subscription
     */
    public function cancelSubscription()
    {
        $this->subscriber->model->status = 'CANCELLED';
        $this->subscriber->model->save();

        $this->processUnsubscription();

        $this->subscriber->model->delete();

        return $this;
    }

    public function processUnsubscription()
    {
        $this->processPayment();

        // Set Payment Token to Null
        $this->setPaymentTokenToNull();

        // update available seats ..
        $this->subscriber->model->event->setting->updateAvailableSeats($this->subscriber->model->registration_type);

    }

    public function setPaymentTokenToNull()
    {
        // If user has more than one tokens , set the token to null
        foreach ( $this->subscriber->model->payments as $payment ) {
            $payment->token = '';
            $payment->save();
        }
    }

    public function processPayment()
    {
        // If has a confirmed payment
        if ( $payment = $this->subscriber->model->paymentSuccess ) {
            // make the refund value
            $payment->status = 'REFUNDING';

            $payment->save();

            // Create a Refund
            $payment->refunds()->create(['user_id' => Auth::user()->id, 'status' => 'PENDING']);
        }

    }

}