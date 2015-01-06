<?php namespace Acme\Contact\Events;

use Acme\Core\Contracts\BaseMailer;
use User;
use Event;

class ContactEventHandler extends BaseMailer {

    /**
     * @param array|\User $array
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $array)
    {
        if ( Event::firing() == 'contact.contact' ) {

            return $this->sendContactMail($array);
        }
    }

    public function sendContactMail(array $array)
    {
        $this->view          = 'emails.contact';
        $this->recepientEmail     = $array['email'];
        $this->recepientName = 'Kaizen Admin';
        $this->senderEmail   = $array['sender_email'];
        $this->senderName        = $array['sender_name'];
        $this->subject       = $array['sender_name'] . ' has contacted you';

        // Send Email
        $this->fire($array);
    }

}