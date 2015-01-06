<?php namespace Acme\Subscription\Events;

use Acme\Core\BaseMailer;
use User;
use Event;

class EventHandler extends BaseMailer {

    /**
     * @param array|\User $array
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $array)
    {
        if ( Event::firing() == 'subscriptions.created' ) {

            return $this->sendSubscriptionMail($array);
        }
    }

    public function sendSubscriptionMail($array)
    {
        $this->view           = 'emails.subscription';
        $this->recepientEmail = $array['email'];
        $this->recepientName  = $array['name_en'];
        $this->subject        = trans('general.subscription_email_subject');

        switch ( $array['status'] ) {
            case 'PENDING' :
                $array['body'] = trans('general.subscription_email_pending', ['title' => $array['title']]);
                break;
            case 'APPROVED' :
                $array['body'] = trans('general.subscription_email_approved', ['title' => $array['title'], 'link' => link_to_action('SubscriptionsController@confirmSubscription', trans('word.click_here'), $array['event_id'])]);
                break;
            case 'CONFIRMED' :
                $array['body'] = trans('general.subscription_email_confirmed', ['title' => $array['title']]);
                break;
            case 'WAITING' :
                $array['body'] = trans('general.subscription_email_waiting', ['title' => $array['title']]);
                break;
            case 'REJECTED' :
                $array['body'] = trans('general.subscription_email_rejected', ['title' => $array['title']]);
                break;
            case 'PAYMENT' :
                $array['body'] = trans('general.subscription_email_payment', ['title' => $array['title'], 'link' => link_to_action('PaymentsController@getPayment', trans('word.click_here'), [$array['event_id'], 'token' => $array['token']])]);
                break;
            default :
                break;
        }
        // If the custom reason set by admin
        if ( !empty($array['reason']) ) {
            $array['body'] = $array['reason'];
        }

        $this->fire($array);
    }


}