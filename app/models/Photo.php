<?php

class Photo extends BaseModel {

    protected $guarded = ['id'];

    protected $table = "photos";

    public function imageable()
    {
        return $this->morphTo();
    }

}
