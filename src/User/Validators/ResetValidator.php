<?php namespace Acme\User\Validators;

use Acme\Core\BaseValidator;

class ResetValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'    => 'required|email',
        'password' => 'required|alpha_num|between:6,12|confirmed'
    );

}
