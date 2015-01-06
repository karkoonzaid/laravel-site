<?php
namespace Acme\Subscription\State\Admin;

use Acme\Subscription\State\AbstractState;
use Acme\Subscription\State\SubscriberState;

class RejectedState extends AbstractState implements SubscriberState {


    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'REJECTED';
        $this->subscriber->model->save();

        $processUnsubscription = $this->subscriber->getCancelledState();
        $processUnsubscription->processUnsubscription();

        return $this;
    }

}