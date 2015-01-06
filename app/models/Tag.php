<?php

use Acme\Core\LocaleTrait;

class Tag extends Eloquent {

    use LocaleTrait;

    protected $localeStrings = ['name'];

    protected $guarded = [];

    protected $table = 'tags';

    public $timestamps = false;

    public function events()
    {
        return $this->morphedByMany('EventModel', 'taggable')->withPivot(['tag_id']);
    }

    public function blogs()
    {
        return $this->morphedByMany('Blog', 'taggable')->withPivot(['tag_id']);
    }

    public function eventTags(){
        return DB::table('tags')
            ->select(['tags.id','tags.name_'.getLocale() .' as name'])
            ->leftJoin('taggables', 'tags.id', '=', 'taggables.tag_id')
            ->where('taggables.taggable_type','EventModel')
            ->groupBy('tags.id')
            ->get();
    }

    public function blogTags(){
        return DB::table('tags')
            ->select(['tags.id','tags.name_'.getLocale() .' as name'])
            ->leftJoin('taggables', 'tags.id', '=', 'taggables.tag_id')
            ->where('taggables.taggable_type','Blog')
            ->groupBy('tags.id')
            ->get();
    }
}