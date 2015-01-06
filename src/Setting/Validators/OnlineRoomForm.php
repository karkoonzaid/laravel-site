<?php namespace Acme\Setting\Validators;

use Acme\Core\BaseValidator;

class OnlineRoomForm extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'online_room_id' => 'required | integer'
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, ['online_room_id']);
    }

}
