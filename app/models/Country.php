<?php

use Acme\Core\LocaleTrait;

class Country extends BaseModel {

    use LocaleTrait;

    protected $guarded = [];

    protected $localeStrings = ['name'];

    public function locations()
    {
        return $this->hasMany('Location');
    }

    public function events()
    {
        return $this->hasManyThrough('EventModel', 'Location');
    }

    public function price($eventId,$type){
        return $this->hasOne('EventPrice')->where('event_id',$eventId)->where('type',$type)->first();
    }

    public function pricesForEvent()
    {
        return $this->hasMany('EventPrice',  'country_id');
    }
}
