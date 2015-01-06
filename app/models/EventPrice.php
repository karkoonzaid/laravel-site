<?php

class EventPrice extends BaseModel {

    protected $guarded = ['id'];


    protected $table = 'event_prices';

    protected $with = ['event','country'];

    public function event()
    {
        return $this->belongsTo('EventModel');
    }

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereType($type);
    }



}
