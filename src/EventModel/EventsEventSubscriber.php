<?php namespace Acme\EventModel ;

class EventsEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('events.*', 'Acme\EventModel\Events\EventHandler');
    }

}
