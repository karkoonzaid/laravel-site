<?php namespace Acme\Libraries;

class UserLocale  {

    protected $geoIp;
    /**
     * @var UserCurrency
     */
    protected $currency;

    /**
     * @param UserGeoIp $geoIp
     * @param UserCurrency $currency
     */
    public function __construct(UserGeoIp $geoIp, UserCurrency $currency  )
    {
        $this->geoIp = $geoIp;
        $this->currency = $currency;
    }

    public function getUserCountry(){
        return $this->geoIp->getCountry();
    }

    public function setUserCountry($country){
        return $this->geoIp->setCountry($country);
    }

} 