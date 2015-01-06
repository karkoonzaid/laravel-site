<?php namespace Acme\Country;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use App;
use Auth;
use Country;
use Illuminate\Support\MessageBag;
use Session;

class CountryRepository extends BaseRepository {

    use CrudableTrait;

    public $defaultCountry = 'KW';
    public $defaultCurrency = 'KWD';

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public function __construct(Country $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getByIso($isoCode)
    {
        return $this->model->where('iso_code', $isoCode)->first();
    }

    /**
     * @return mixed
     * Get
     * @todo : Cache the Query
     */
    public function availableCountries()
    {
        $selectedCountry = Session::has('user.country') ? Session::get('user.country') : null ;
        $query = $this->model->whereNotIn('iso_code',[$selectedCountry])->get();
        return $query;
    }

    public function supportedCountries()
    {
        return $this->model->lists('iso_code');
    }

    public function setRegion()
    {
        if ( Session::has('user.country') ) {
            $country = Session::get('user.country');
        } elseif ( Auth::check() ) {
            if ( !is_null(Auth::user()->country) ) {
                $countryId = Auth::user()->country_id;
                if ( $country = Country::find($countryId) ) {
                    $country = $country->iso_code;
                    Session::put('user.country', $country);
                }
            }
        }

        if ( empty($country) ) {
            // find by IP
            $class   = App::make('Acme\Libraries\UserGeoIp');
            $country = $class->getCountry();
            Session::put('user.country', $country);
        }

        if ( empty($country) ) {
            $country = $this->defaultCountry;
            Session::put('user.country', $country);
        }

        return $country;
    }

}