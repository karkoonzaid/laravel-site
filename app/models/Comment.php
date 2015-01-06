<?php

use McCool\LaravelAutoPresenter\PresenterInterface;

class Comment extends BaseModel implements PresenterInterface {

    protected $guarded = ['id'];

    public function author()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function child()
    {
        return $this->hasMany('Comment', 'parent_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function getPresenter()
    {
        return 'Acme\Comment\Presenter';
    }
}
