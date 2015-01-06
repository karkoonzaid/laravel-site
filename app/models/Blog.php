<?php

use Acme\Blog\BlogPresenter;
use Acme\Core\LocaleTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Blog extends BaseModel implements PresenterInterface {

    use LocaleTrait;

    use SoftDeletingTrait;

    protected $guarded = [];

    protected $table = "posts";

    protected $localeStrings = ['title', 'description'];

    /*********************************************************************************************************
     * Eloquent Relationships
     ********************************************************************************************************/
    public function author()
    {
        return $this->belongsTo('User', 'user_id')->select('id', 'username', 'email');
    }

    public function comments()
    {
        return $this->morphMany('Comment', 'commentable');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    public function photos()
    {
        return $this->morphMany('Photo', 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }

    public function categories()
    {
        return $this->hasMany('Category', 'category_id');
    }

    public function getPresenter()
    {
        return 'Acme\Blog\Presenter';
    }

    public function latest($count)
    {
        return $this->orderBy('created_at', 'DESC')->remember(10)->limit($count)->get();
    }

    public function beforeDelete()
    {
        // Delete the comments
        $this->comments()->delete();
    }
}
