<?php namespace Acme\Photo\Validators;

use Acme\Core\BaseValidator;

class CreateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [
        'imageable_type'=>'required',
        'imageable_id'=>'required | integer',
        'featured' => 'boolean'
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
             'imageable_type','imageable_id','featured'
        ]);
    }

}
