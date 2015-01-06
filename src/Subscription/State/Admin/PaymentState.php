<?php
namespace Acme\Subscription\State\Admin;

use Acme\Subscription\State\SubscriberState;
use Acme\Subscription\State\AbstractState;

class PaymentState extends AbstractState implements SubscriberState {

    public $subscriber;

    public $payment;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'PAYMENT';
        $token = md5(uniqid(mt_rand(), true));
        $this->subscriber->model->payments()->create(['user_id'=>$this->subscriber->model->user_id,'token'=>$token,'status'=>'PENDING']);
        $this->subscriber->messages->add('token', $token);
        $this->subscriber->model->save();
    }

}