<?php namespace Acme\Contact\Validators;

use Acme\Core\BaseValidator;

class ContactValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'sender_email'=>'required|email',
        'sender_name'=>'required',
        'body' => 'required|min:5'
    );

}
