<?php

use Acme\Core\LocaleTrait;

class Location extends BaseModel {

    use LocaleTrait;

    protected $guarded = [];

    protected $localeStrings = ['name'];

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function events()
    {
        return $this->hasMany('EventModel');
    }
}
