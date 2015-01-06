<?php namespace Acme\Package\Validators;

use Acme\Core\BaseValidator;

class CreateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [
        'title_ar'=>'required',
        'description_ar'=>'required',
        'free' => 'required_if:price,0',
        'price' => 'integer'
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
             'title_ar', 'title_en', 'description_ar', 'description_en', 'free' , 'price'
        ]);
    }

}
