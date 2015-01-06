<?php

use Acme\Country\CountryRepository;
use Acme\User\UserRepository;

class LocaleController extends BaseController {

    private $userRepository;

    private $countryRepository;

    /**
     * @param UserRepository $userRepository
     * @param CountryRepository $countryRepository
     */
    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
    {
        parent::__construct();
        $this->userRepository    = $userRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @param $country
     * @return \Illuminate\Http\RedirectResponse
     * Set User's Country
     */
    public function setCountry($country)
    {
        // Save the Country Param in Session
        Session::put('user.country', $country);

        // If user is logged in, Save the country in database
        if ( Auth::check() ) {
            $user    = Auth::user();
            $country = $this->countryRepository->model->where('iso_code', $country)->first();
            if ( $country ) {
                $user->country_id = $country->id;
                $user->save();
            }
        }

        return Redirect::back();
    }

}