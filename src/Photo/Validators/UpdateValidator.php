<?php namespace Acme\Package\Validators;

use Acme\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'phone'    => 'numeric',
        'mobile'   => 'required|numeric',
        'name_en'  => 'required|alpha_num|between:3,40',
        'name_ar'  => 'required|between:3,40',
        'password' => 'alpha_num|between:6,12|confirmed',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'user_id', 'category_id', 'location_id', 'title_ar', 'title_en', 'description_ar', 'description_en', 'total_seats', 'price', 'date_start', 'date_end', 'address_ar', 'street_ar', 'address_en', 'street_en', 'phone', 'email', 'latitude', 'longitude', 'button_ar', 'button_en'
        ]);
    }

}
