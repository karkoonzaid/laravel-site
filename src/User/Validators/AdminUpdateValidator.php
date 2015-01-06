<?php namespace Acme\User\Validators;

use Acme\Core\BaseValidator;
use Auth;
use User;

class AdminUpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
//        'phone'    => 'sometimes|numeric',
//        'mobile'   => 'sometimes|numeric',
        'username' => 'unique:users,username',
        'active' => 'boolean',
        'email'    => 'email|unique:users,email,:id',
        'password' => 'sometimes|alpha_num|between:6,12|confirmed',
//        'name_ar'  => 'sometimes',
//        'name_en'  => 'sometimes',
    );

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar', 'name_en', 'password', 'password_confirmation', 'country_id', 'twitter', 'phone', 'mobile','active','username','email'
        ]);
    }

    /**
     * Remove Password field if empty
     */
    public function beforeValidation()
    {
        if ( empty($this->inputData['password']) )
            unset($this->inputData['password']);

        {
            $user = User::find($this->inputData['user_id']);
            $user->email = $this->inputData['email'];
            $user->username = $this->inputData['username'];

            if ( ! $user->isDirty('email') ) {
                unset($this->inputData['email']);
            }
            if ( ! $user->isDirty('username') ) {
                unset($this->inputData['username']);
            }

        }
    }


}
