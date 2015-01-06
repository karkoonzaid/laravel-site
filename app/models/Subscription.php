<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Subscription extends BaseModel {

    use SoftDeletingTrait;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $with = ['user'];

    /*********************************************************************************************************
     * Eloquent Relationships
     ********************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo('EventModel', 'event_id');
    }

    public function settings()
    {
        return $this->hasManyThrough('Setting', 'EventModel', 'id', 'settingable_id');
    }

    public function payments()
    {
        return $this->morphMany('Payment', 'payable');
    }



    /*********************************************************************************************************
     * Custom Methods
     ********************************************************************************************************/

    /**
     * If the User already confirmed
     */
    public function subscriptionConfirmed()
    {
        return $this->status == 'CONFIRMED' ? true : false;
    }


    public function hasSubscribed($userId)
    {
        if($this->contains($userId)) {
        }
        return $this->status != 'CANCELLED' ? true : false;
    }

    /**
     * @return mixed
     * Check If a User Has Confirmed The Payment
     */
    public function paymentSuccess()
    {
        $query = $this->morphOne('Payment', 'payable')->where('user_id', Auth::user()->id)->where('status', 'CONFIRMED');

        return $query;
    }

}
