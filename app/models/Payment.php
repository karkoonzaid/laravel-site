<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Payment extends BaseModel {

    use SoftDeletingTrait;

    protected $guarded = ['id'];

    protected $table = "payments";


    public function refunds()
    {
        return $this->hasMany('Refund');
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = str_replace(',','',$value);
    }


}