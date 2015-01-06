<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Refund extends BaseModel {

    use SoftDeletingTrait;

    protected $guarded = ['id'];

    protected $table = "refunds";

    public function payment()
    {
        return $this->belongsTo('Payment');
    }

    public function user(){
        return $this->belongsTo('User');
    }

}