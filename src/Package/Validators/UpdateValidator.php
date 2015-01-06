<?php namespace Acme\Package\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'title_ar'=>'required',
        'description_ar'=>'required',
        'free' => 'required_if:price,0',
        'price' => 'integer'
    );

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
