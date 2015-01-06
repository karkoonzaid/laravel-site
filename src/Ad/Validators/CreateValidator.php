<?php namespace Acme\Ad\Validators;

use Acme\Core\BaseValidator;

class CreateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'title_ar'       => 'required',
        'url'    => 'required|url'
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'title_ar','title_en','url'
        ]);
    }
}
