<?php namespace Acme\Contact;

class ContactEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('contact.contact', 'Acme\Contact\Events\ContactEventHandler');
    }

}
