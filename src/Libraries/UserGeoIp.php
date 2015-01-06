<?php namespace Acme\Libraries;

use Acme\Country\CountryRepository;
use Acme\User\UserRepository;
use App;
use Config;
use GeoIp2\Database\Reader;

class UserGeoIp {

    protected $reader;

    private $country;

    private $isoCode;

//    protected $defaultCountry = 'KW';
//
//    protected $supportedCountries = ['KW', 'QA', 'BH', 'AE', 'OM', 'SA'];
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @param UserRepository $userRepository
     * @param CountryRepository $countryRepository
     */
    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
    {
        $this->reader         = new Reader(Config::get('app.geoDb'));
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->detectUserCountry();
    }

    public function getClientIP()
    {
        if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if ( !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
            return null;
        }

        if(App::environment() == 'local') {
            return null;
        }

        return $ip;

    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function detectUserCountry()
    {
        $ip = $this->getClientIP();
        if ( !is_null($ip) ) {
            $record  = $this->reader->country($this->getClientIP());
            $country = $record->country->isoCode;

            if ( empty($country) || !in_array($country, $this->countryRepository->supportedCountries()) ) {
                $this->setCountry($this->countryRepository->defaultCountry);
            } else {
                $this->setCountry($country);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }


} 