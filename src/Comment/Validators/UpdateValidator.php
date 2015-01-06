<?php namespace Acme\Comment\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

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
