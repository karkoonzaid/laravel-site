<?php namespace Acme\Libraries;

use App;
use CurrencyConverter\CurrencyConverter;

class UserCurrency {

    public $currency;

    public function __construct()
    {
        $this->currency = new CurrencyConverter;
        $this->country = App::make('Acme\Country\CountryRepository');
        setlocale(LC_MONETARY, 'en_US');
    }

    public function convert($to = 'KWD', $amount )
    {
        $converter =  $this->currency->convert($this->country->defaultCurrency,$to,$amount);
        return money_format("%!n",round($converter));
    }
} 