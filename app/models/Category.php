<?php

use Acme\Core\LocaleTrait;

class Category extends BaseModel {

    use LocaleTrait;

    protected $guarded = [];

    protected $table = "categories";

    protected $localeStrings = ['name'];

    public function events()
    {
        return $this->hasMany('EventModel');
    }

    public function posts()
    {
        return $this->hasMany('Blog');
    }
}
