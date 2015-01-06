<?php namespace Acme\Country\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'name_ar'       => 'required',
        'iso_code'       => 'required',
        'currency' => 'required'
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar','name_en','iso_code','currency'
        ]);
    }
}

