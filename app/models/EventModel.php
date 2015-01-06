<?php

use Acme\Core\LocaleTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

class EventModel extends BaseModel implements PresenterInterface {

    use LocaleTrait;

    use SoftDeletingTrait;

    protected $guarded = ['id'];

    protected $localeStrings = ['title', 'description', 'address', 'street', 'button'];

    protected $table = "events";

    protected $dates = ['date_start', 'date_end'];

    /*********************************************************************************************************
     * Eloquent Relationships
     ********************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function comments()
    {
        return $this->morphMany('Comment', 'commentable')->where('parent_id',0)->orWhere('parent_id',NULL);
    }

    public function author()
    {
        return $this->belongsTo('User', 'user_id')->select('id', 'username', 'email');
    }

    public function categories()
    {
        return $this->belongsTo('Category', 'category_id')->select('name', 'name_en', 'type', 'slug');
    }

    public function followers()
    {
        return $this->belongsToMany('User', 'followers', 'event_id', 'user_id');
    }

    public function favorites()
    {
        return $this->belongsToMany('User', 'favorites', 'event_id', 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('Subscription', 'event_id');
    }

    public function subscribers()
    {
        return $this->belongsToMany('User', 'subscriptions', 'event_id', 'user_id')->whereNull('deleted_at');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    public function location()
    {
        return $this->belongsTo('Location');
    }

    public function photos()
    {
        return $this->morphMany('Photo', 'imageable');
    }

    public function type()
    {
        return $this->hasOne('Type', 'event_id');
    }

    public function setting()
    {
        return $this->morphOne('Setting', 'settingable');
    }

    public function package()
    {
        return $this->belongsTo('Package');
    }

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }

    public function requests()
    {
        return $this->hasMany('EventRequest', 'event_id');
    }

    public function reorganize()
    {
        return $this->belongsToMany('User', 'requests', 'event_id', 'user_id');
    }

    public function eventCountries()
    {
        return $this->belongsToMany('Country', 'event_countries', 'event_id', 'country_id');
    }

    public function eventPrices()
    {
        return $this->belongsToMany('Country', 'event_prices', 'event_id', 'country_id');
    }

    public function prices()
    {
        return $this->hasMany('EventPrice', 'event_id');
    }

    public function eventPricesByType($type)
    {
        return $this->belongsToMany('Country', 'event_prices', 'event_id', 'country_id')->where('type', $type)->withPivot(['price', 'type']);
    }


    /*********************************************************************************************************
     * Setters
     ********************************************************************************************************/
    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $this->dateStringToCarbon($value);
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $this->dateStringToCarbon($value);
    }

    public function setTotalSeatsAttribute($value)
    {
        $this->attributes['total_seats'] = (int) ($value);
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = floatval($value);
    }

    /*********************************************************************************************************
     * Getters
     ********************************************************************************************************/

    /** gets the past events */
    public function getPastEvents()
    {
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '<', Carbon::now()->toDateTimeString());
    }

    public function getHumanCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();

        return null;
    }

    /**
     * @param int $days
     * @return \Illuminate\Database\Query\Builder|static
     * get Recent Event by Days
     */
    public static function getRecentEvents($days)
    {
        $dt = Carbon::now()->addDays($days);

        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '<', $dt->toDateTimeString());
    }

    public function getPriceByCountry($countryID)
    {
        return $this->hasMany('EventPrice', 'event_id')->where('country_id', $countryID);
    }

    public function getPriceByCountryAndType($countryID, $type)
    {
        return $this->hasOne('EventPrice', 'event_id')->where('country_id', $countryID)->where('type', $type);
    }

    public function getConfirmedUsers()
    {
        return $this->whereHas('subscriptions', function ($q) {
            $q->where('subscriptions.status', '=', 'CONFIRMED');
        })->get();
    }

    public function getDates()
    {
        return array_merge(array('created_at', 'updated_at'), $this->dates);
    }

    /** Get the presenter class. */
    public function getPresenter()
    {
        return 'Acme\EventModel\Presenter';
    }

    /*********************************************************************************************************
     * Model Scopes
     ********************************************************************************************************/
    public function scopeNotExpired($query)
    {
        return $query->where('date_start', '>', Carbon::now()->toDateTimeString());
    }

    /*********************************************************************************************************
     * Custom Methods
     ********************************************************************************************************/
    public function formatEventDate($column)
    {
        $dt = Carbon::createFromTimestamp(strtotime($column));

        return $dt->format('M jS  Y \\a\\t ga');
    }

    public function formatEventTime($column)
    {
        $dt = Carbon::createFromTimestamp(strtotime($column));

        return $dt->format('g a');
    }

    /**
     * Updates the Available Seats
     */
    public function updateAvailableSeats()
    {
        $totalSeats = $this->total_seats;
        // If Total Seats is Greater than 0
        // Which means is not unlimited seats
        if ( $totalSeats > 0 ) {

            // Get the confirmed subscriptions count for the event
            $totalSubscriptions = $this->subscriptions()->where('status', 'CONFIRMED')->count();

            // calculate the available seats
            $available_seats = $totalSeats - $totalSubscriptions;

        } else {
            $available_seats = 0;
        }

        $this->available_seats = (int) ($available_seats);

        $this->save();
    }

    protected function dateStringToCarbon($date, $format = 'm/d/Y')
    {
        if ( !$date instanceof Carbon ) {
            $validDate = false;
            try {
                $date      = Carbon::createFromFormat($format, $date);
                $validDate = true;
            }
            catch ( Exception $e ) {
            }

            if ( !$validDate ) {
                try {
                    $date      = Carbon::parse($date);
                    $validDate = true;
                }
                catch ( Exception $e ) {
                }
            }

            if ( !$validDate ) {
                $date = null;
            }
        }

        return $date;
    }

    public function hasAvailableSeats()
    {
        return $this->available_seats > 0 ? true : false;
    }

    public function isAuthor($userId)
    {
        return $this->user_id === $userId ? true : false;
    }

    public function isFreeEvent()
    {
        if ( $this->free ) {
            return true;
        }

        return false;
    }

    public function beforeDelete()
    {

        //delete settings
        $this->setting()->delete();

        //todo :delete taggables

        // delete photos, images from server
        $this->photos()->delete();

        // delete followings
        $followings = $this->hasMany('Follower', 'event_id');
        foreach ( $followings->get(array('followers.id')) as $following ) {
            $following->delete();
        }

        // delete favorites
        $favorites = $this->hasMany('Favorite', 'event_id');
        foreach ( $favorites->get(array('favorites.id')) as $favorite ) {
            $favorite->delete();
        }

        // delete subscriptions
        foreach ( $this->subscriptions()->get(array('subscriptions.id')) as $subscription ) {
            $subscription->delete();
        }

        // delete requests
        foreach ( $this->requests()->get(array('requests.id')) as $request ) {
            $request->delete();
        }

    }

    public function latest($count)
    {
        return $this->orderBy('created_at', 'DESC')->select('id', 'title_ar', 'slug', 'title_en')->remember(10)->limit($count)->get();
    }


}

