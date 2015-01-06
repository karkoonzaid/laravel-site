<?php namespace Acme\User\Events;

use Acme\Core\BaseMailer;
use User;
use Event;

class EventHandler extends BaseMailer {

    /**
     * @param array|\User $user
     * @internal param array $data Handle the* Handle the
     */

    public function handle(array $user)
    {
        if ( Event::firing() == 'user.created' ) {
            return $this->sendActivationMail($user);
        } elseif ( Event::firing() == 'user.activated' ) {
            return $this->sendWelcomeMail($user);
        } elseif ( Event::firing() == 'user.deactivated' ) {
            return $this->sendDeactivatedMail($user);
        } elseif ( Event::firing() == 'user.reset' ) {
            return $this->sendPasswordResetMail($user);
        }
    }

    public function sendActivationMail($user)
    {
        $this->view = 'emails.auth.default';
        $this->recepientEmail = $user['email'];
        $this->recepientName  = $user['name_ar'];

        if ( $user['active'] == 1 ) {
            // When user gets activated
            $this->subject        = trans('word.welcome_to_kaizen');
            $user['body'] = trans('auth.account_activated.body') . ' '. $user['email'] . '<br>'.trans('auth.account_activated.click_here_to_login').'<a href="' . action('AuthController@getLogin') . '"> '.action('AuthController@getLogin').' </a>';
        } else {
            $this->subject        = trans('auth.account_confirmation.subject');
            $user['body'] =  trans('auth.account_confirmation.body').'<br><a href="' . action('AuthController@activate', $user['confirmation_code']) . '"> '.action('AuthController@activate', $user['confirmation_code']).' </a>' ;
        }

        // Send Email
        $this->fire($user);
    }

    public function sendWelcomeMail($user)
    {
        $this->sendActivationMail($user);
    }


    public function sendDeactivatedMail($user)
    {
        $this->view = 'emails.auth.default';
        $this->recepientEmail = $user['email'];
        $this->recepientName  = $user['name_ar'];

        $this->subject        = 'Your Kaizen Account has been deactivated.';
        $user['body']         = 'Your Kaizen Account assosiated with email '.$user['email'].' has been deactivated. Please <a href="' . action('ContactsController@index') . '"> Contact Admin </a> for Further Details';

    }


}