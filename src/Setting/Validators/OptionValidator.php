<?php namespace Acme\Setting\Validators;

use Acme\Core\BaseValidator;

class OptionValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [
//        'normal_total_seats' => 'required|sometimes',
//        'online_total_seats' => 'required|sometimes',
//        'vip_total_seats'    => 'required|sometimes',
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'normal_description_en', 'normal_description_ar', 'vip_description_en', 'vip_description_ar', 'online_description_en', 'online_description_ar', 'vip_total_seats', 'online_total_seats','normal_total_seats'
        ]);
    }

    public function beforeValidation()
    {
        $requiredFields = ['normal_total_seats', 'online_total_seats', 'vip_total_seats'];

        foreach ( $requiredFields as $key ) {
            if ( array_key_exists($key, $this->inputData) ) {
                $this->rules[$key] = 'required|not_in:0,0.00';
            }
        }


    }

}
