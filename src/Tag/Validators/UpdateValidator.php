<?php namespace Acme\Tag\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'name_ar'       => 'required',
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar','name_en'
        ]);
    }
}

