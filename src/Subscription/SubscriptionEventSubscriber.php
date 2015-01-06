<?php namespace Acme\Subscription;

class SubscriptionEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('subscriptions.*', 'Acme\Subscription\Events\EventHandler');
    }

}
