<?php namespace Acme\User\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
        'phone'    => 'numeric',
        'mobile'   => 'required|numeric',
        'name_ar'  => 'required|min:3',
        'name_en'  => 'required|min:3',
        'password' => 'alpha_num|between:6,12|confirmed',
        'countrycode' => 'required|numeric',
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
            'name_ar', 'name_en', 'password', 'password_confirmation', 'twitter', 'phone', 'mobile','gender','instagram', 'countrycode','country'
        ]);
    }

    /**
     * Remove Password field if empty
     */
    public function beforeValidation()
    {
        if ( empty($this->inputData['password']) )
            unset($this->inputData['password']);

    }


}
