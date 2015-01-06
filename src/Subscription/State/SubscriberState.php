<?php  namespace Acme\Subscription\State;

interface SubscriberState {

    public function createSubscription();

    public function cancelSubscription();

} 