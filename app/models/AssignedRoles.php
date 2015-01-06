<?php

class AssignedRoles extends BaseModel {

    public static $rules = array();

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

}