<?php namespace Acme\User;

use Acme\Core\BaseRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\MessageBag;
use Password;
use Session;
use User;

class AuthService extends BaseRepository {

    public $errors;
    public $userRepository;


    /**
     * @param UserRepository $userRepository
     * @param MessageBag $errors
     */
    public function __construct(UserRepository $userRepository,MessageBag $errors)
    {
        $this->userRepository = $userRepository;
        $this->errors  = $errors;
    }

    /**
     * Create
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function register(array $data)
    {
//        $data['confirmation_code'] = $this->generateToken();

        // If in Admin panel active is set, that will override this
        if(!isset($data['active'])) {
            $data['active'] = 0;
        }
        if ( ! $user = $this->userRepository->create($data) ) {
            $this->addError(trans('auth.alerts.user_registration_failed'));

            return false;
        }

        $this->processActivation($user);

//        Event::fire('user.created',[$data]);

        return true;
    }

    /**
     * Delete
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $user = $this->find($id);

        if ( $user ) {
            return $user->delete();
        }
    }

    /**
     * Register / Activte a User
     * @param $token
     * @return string
     */
    public function activateUser($token)
    {
        $user = $this->findByToken($token);
        if ( $user ) {
            // valid token
            // check if user is active
            if ( $user->active == 1 ) {
                // Error: account already active
                $this->addError(trans('auth.alerts.account_already_active'));

                return false;
            }

            if ( $user->created_at < Carbon::now()->subDay() ) {
                // link expired
                //@todo make link expired view
                $this->addError(trans('auth.alerts.token_link_expired'));

                return false;
            }
            $this->activate($user);

            return true;

        }
        $this->addError(trans('word.invalid_token'));

        return false;
    }

    /**
     * Find User By Confirmation Token
     * @param $token
     * @return mixed
     */
    private function findByToken($token)
    {
        $user = $this->userRepository->findByToken($token);

        return $user;
    }

    /**
     * Updated User Last Logged In Time
     */
    public function updateLastLoggedAt()
    {
        $user                 = Auth::user();
        $user->last_logged_at = Carbon::now();
        $user->save();
    }

    public function sendResetLink($email)
    {
        // check for valid user
        $user = $this->userRepository->findByEmail($email['email']);

        // Check if Valid User
        if ( $user ) {
            // Check if his Account is active
            if ( ! $user->active == 1 ) {
                $this->addError(trans('auth.alerts.not_confirmed'));

                return false;
            }
            // new confirmation code
            $user->token = $this->generateToken();
            $user->save();
            Event::fire('user.reset', $user);

            return true;
        }
        $this->addError(trans('auth.alerts.invalid_user'));

        return false;

    }

    /**
     * @return string
     */
    public function generateToken()
    {
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * @param $credentials
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(array $credentials)
    {
        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        return $response;

    }

    public function getRegistrationForm()
    {

        return $this->userRepository->getCreateForm();

    }

    public function getPasswordResetForm()
    {
        return $this->userRepository->getPasswordResetForm();
    }

    private function activate($user)
    {
//        // activate user
        $user->active = 1;

        // set confirmation code to null
        $user->confirmation_code = '';

        $user->save();

        Event::fire('user.activated',[$user->toArray()]);
    }

    public function deactivate($user)
    {
        $user->active = 0;

        // set confirmation code to null
        $user->confirmation_code = '';

        $user->save();

        Event::fire('user.deactivated',[$user->toArray()]);
    }

    public function changeActivateStatus($user)
    {
        if($user->active) {
            $this->deactivate($user);
        } else {
            $this->activate($user);
        }
    }

    public function processActivation(User $user)
    {
        Session::has('user_id') ? Session::forget('user_id') : '';
        Session::has('account_not_active') ? Session::forget('account_not_active') : '';

        $user->confirmation_code = $this->generateToken();
        $user->save();

        $data = $user->toArray();
        $data['confirmation_code'] = $user->confirmation_code;

        Event::fire('user.created',[$data]);
    }
}