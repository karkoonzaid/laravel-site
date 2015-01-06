<?php namespace Acme\Comment\Validators;

use Acme\Core\BaseValidator;

class CreateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'content' => 'required'
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'content','user_id','parent_id'
        ]);
    }
}
