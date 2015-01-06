<?php namespace Acme\Location\Validators;

use Acme\Core\BaseValidator;

class CreateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'name_ar'       => 'required',
        'country_id'    => 'required|integer'
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar','name_en','country_id'
        ]);
    }
}
