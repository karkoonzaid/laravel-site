<?php

use Acme\Country\CountryRepository;
use Acme\Libraries\UserGeoIp;
use Acme\User\AuthService;
use Acme\User\UserRepository;

class AuthController extends BaseController {

    /**
     * @var AuthRepository
     */
    private $service;
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param AuthService $service
     * @param CountryRepository $countryRepository
     * @param UserRepository $userRepository
     */
    public function __construct(AuthService $service, CountryRepository $countryRepository, UserRepository $userRepository)
    {
        $this->service = $service;
        parent::__construct();

        // restrict authenticated users from pages except logout
        $this->beforeFilter('noAuth', ['except' => ['getLogout']]);
        $this->countryRepository = $countryRepository;
        $this->userRepository    = $userRepository;
    }

    public function getLogin()
    {
        $this->title = trans('auth.login.title');
        $this->render('site.auth.login');
    }

    public function postLogin()
    {
        $email    = Input::get('email');
        $password = Input::get('password');
        $remember = Input::has('remember') ? true : false;

        if ( !Auth::attempt(['email' => $email, 'password' => $password], $remember) ) {
            return Redirect::action('AuthController@getLogin')->with('error', trans('auth.alerts.wrong_credentials'));
        }

        if ( !Auth::user()->active ) {
            Session::put('account_not_active', true);
            Session::put('user.id', Auth::user()->id);
            Auth::logout();

            return Redirect::action('AuthController@getLogin')->with('error', trans('auth.alerts.not_confirmed'));
        }

        $this->service->updateLastLoggedAt();

        return Redirect::action('UserController@getProfile',Auth::user()->id);

//        return Redirect::intended('/');
    }


    /**
     * User Registeration Page
     */
    public function getSignup()
    {
        $this->title = trans('auth.signup.title');
        $this->render('site.auth.signup');
    }


    public function postSignup()
    {
        // get the registration form
        $val = $this->service->getRegistrationForm();

        // check if the form is valid
        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        // If Auth Sevice Fails to Register the User
        if ( !$this->service->register($val->getInputData()) ) {

            return Redirect::home()->with('errors', $this->service->errors());
        }

        return Redirect::action('AuthController@getLogin')->with('success', trans('auth.alerts.account_created'));

    }

    /**
     * Display The  Forgot Password Form
     * @return Response
     */
    public function getForgot()
    {
        $this->title = trans('auth.forgot.title');
        $this->render('site.auth.forgot');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postForgot()
    {
        $response = Password::remind(Input::only('email'), function ($message) {
            $message->subject(trans('auth.reset.title'));

        });
        switch ( $response ) {
            case Password::INVALID_USER:
                return Redirect::back()->with('error', trans('auth.alerts.invalid_user'));

            case Password::REMINDER_SENT:
                return Redirect::action('AuthController@getLogin')->with('success', trans('auth.alerts.reminders_sent'));
        }

    }

    /**
     * Display the password reset form.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        $this->title = trans('auth.reset.title');
        $this->render('site.auth.reset', array('token' => $token));
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $credentials = Input::only(
            'email', 'password', 'password_confirmation', 'token'
        );

        // validate
        $val = $this->userRepository->getPasswordResetForm();

        // check if the form is valid
        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $response = $this->service->resetPassword($credentials);


        switch ( $response ) {

            case Password::INVALID_PASSWORD:
                return Redirect::back()->with('error', Lang::get('auth.alerts.wrong_password_reset'))->withInput();
            case Password::INVALID_TOKEN:
                return Redirect::back()->with('error', Lang::get('auth.alerts.wrong_token'))->withInput();
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get('auth.alerts.invalid_user'))->withInput();
            case Password::PASSWORD_RESET:
                return Redirect::action('AuthController@getLogin')->with('success', trans('auth.alerts.password_resetted'));

        }
    }

    /**
     * Logout a User
     */
    public function getLogout()
    {
        Auth::logout();

        return Redirect::home();
    }

    /**
     * @param $token
     * Confirm the User and Activate
     * Lands on this page When User Clicks the Activation Link in Email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($token)
    {
        // If not activated ( errors )
        if ( !$this->service->activateUser($token) ) {

            return Redirect::home()->with('errors', $this->service->errors());
        }

        // redirect to home with active message
        return Redirect::action('AuthController@getLogin')->with('success', trans('auth.alerts.account_activated'));

    }

    public function sendActivationLink()
    {


        $userId = Input::get('user_id');
        $user   = $this->userRepository->findById($userId);
        if ( $user ) {
            $this->service->processActivation($user);

            return Redirect::back()->with('success', trans('auth.alerts.account_activation_link_sent'));
        }

        return Redirect::back()->with('error', trans('auth.alerts.invalid_user'));

    }

}