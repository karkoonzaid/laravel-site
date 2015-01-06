<?php namespace Acme\Core;

use App;
use Country;
use McCool\LaravelAutoPresenter\BasePresenter as AbstractPresent;
use Session;

abstract class BasePresenter extends AbstractPresent {

    public function __construct(Model $model) {
        $this->resource = $model;
    }

    public function created_at()
    {
        return $this->resource->created_at->diffForHumans();
    }

    /**
     * @param $field
     * @return string
     */
    public function convertCurrency($field)
    {
        $iso = Session::get('user.country');
        if ( $iso == 'KW' ) {
            return $field . ' KD';
        }

        $converter = App::make('Acme\Libraries\UserCurrency');
        $country   = Country::where('iso_code', $iso)->first();


//        if ( $country ) {
//            $converter = $converter->convert($country->currency, $field);
//            if ( empty($converter) ) {
//                return $field . ' KD';
//            }
//
//            return $converter . ' ' . $country->currency;
//        } else {
//            return $field . ' KD';
//        }
    }


}
