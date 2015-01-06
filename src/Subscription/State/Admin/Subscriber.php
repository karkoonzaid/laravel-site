<?php namespace Acme\Subscription\State\Admin;

use Acme\Subscription\State\CancelledState;
use Acme\Subscription\State\ConfirmedState;
use Acme\Subscription\State\PendingState;
use Acme\Subscription\State\Subscriber as BaseSubscriber;
use Acme\Subscription\State\WaitingState;
use Illuminate\Support\MessageBag;
use Subscription;

class Subscriber extends BaseSubscriber {

    public $confirmed;
    public $approved;
    public $waiting;
    public $rejected;
    public $pending;
    public $payment;
    public $cancelled;

    public $model;

    public $subscriptionState;
    public $messages;

    private $reason;

    public function __construct(Subscription $subscription, $status, $reason)
    {
        $this->confirmed         = new ConfirmedState($this);
        $this->waiting           = new WaitingState($this);
        $this->rejected          = new RejectedState($this);
        $this->pending           = new PendingState($this);
        $this->approved          = new ApprovedState($this);
        $this->payment           = new PaymentState($this);
        $this->messages          = new MessageBag();
        $this->cancelled         = new CancelledState($this);
        $this->model             = $subscription;
        $status                  = strtolower($status);
        $this->subscriptionState = $this->{$status};
        $this->reason            = strip_tags($reason);

        if ( !(empty($this->reason)) ) {
            $this->messages->add('reason', $reason);
            return $this;
        }

    }


}