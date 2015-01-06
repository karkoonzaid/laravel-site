<?php

class Package extends BaseModel {

    protected $guarded = [];

    protected static $name = 'package';

    protected $table = 'packages';

    protected $localeStrings = ['title', 'description'];

    public function setting()
    {
        return $this->morphOne('Setting', 'settingable');
    }

    public function events()
    {
        return $this->hasMany('EventModel', 'package_id');
    }

    public function beforeDelete()
    {
        $this->setting()->delete();

        // delete events that belongs to this model
        foreach ( $this->events()->get(array('id')) as $event ) {
            $event->delete();
        }

    }

}
