<?php

use Acme\Core\LocaleTrait;

class Ad extends BaseModel {

    use LocaleTrait;

    protected $guarded = ['id'];

    protected $table = "ads";

    public static $rules = [];

    protected $localeStrings = ['title'];

    public function photos()
    {
        return $this->morphMany('Photo', 'imageable');
    }

}