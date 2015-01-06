<?php

class EventCountry extends BaseModel {

    protected $guarded = ['id'];


    protected $table = 'event_countries';

    public function events()
    {
        return $this->belongsToMany('EventModel');
    }

    public function countries()
    {
        return $this->belongsToMany('Country');
    }

}
