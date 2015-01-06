<?php
namespace Acme\Subscription\State;

class AbstractState {

    public function cancelSubscription()
    {
        return $this->subscriber->setUnSubscriptionState($this->subscriber->getCancelledState());
    }


} 