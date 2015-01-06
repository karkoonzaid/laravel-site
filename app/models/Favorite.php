<?php

class Favorite extends BaseModel {

	protected $guarded = [];


    public  function users() {
        return $this->belongsTo('User');
    }

    public  function events() {
        return $this->belongsTo('EventModel');
    }

}
