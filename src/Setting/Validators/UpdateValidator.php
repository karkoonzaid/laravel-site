<?php namespace Acme\Setting\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'approval_type'      => 'required',
        'registration_types' => 'required | array',
        'vip_price'          => 'integer',
        'online_price'       => 'integer',
        'normal_price'       => 'integer',
        'country_ids'        => 'required | array',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'approval_type', 'registration_types', 'normal_description_en', 'normal_description_ar', 'vip_description_en', 'vip_description_ar', 'online_description_en', 'online_description_ar', 'vip_price', 'online_price', 'country_ids'
        ]);

    }

    public function afterValidation()
    {
        unset($this->inputData['country_ids']);
    }
}
