<?php

use Acme\Country\CountryRepository;
use Acme\EventPrice\EventPriceRepository;
use Acme\EventModel\EventRepository;
use Acme\Setting\SettingRepository;
use Illuminate\Support\Facades\Redirect;

class AdminSettingsController extends AdminBaseController {

    private $settingRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var EventPriceRepository
     */
    private $eventPriceRepository;

    /**
     * @param SettingRepository $settingRepository
     * @param CountryRepository $countryRepository
     * @param EventRepository $eventRepository
     * @param EventPriceRepository $eventPriceRepository
     */
    public function __construct(SettingRepository $settingRepository, CountryRepository $countryRepository, EventRepository $eventRepository, EventPriceRepository $eventPriceRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->countryRepository = $countryRepository;
        parent::__construct();
        $this->eventRepository      = $eventRepository;
        $this->eventPriceRepository = $eventPriceRepository;
    }


    /**
     *
     * @return Jump to store method
     * Direct access to this method is not allowed
     */
    public function create()
    {
        // check for valid session
        $this->checkValidSession();
    }


    /**
     * @param $id
     * Event ID or Package ID .. settable_id
     */
    public function edit($id)
    {
        $setting                  = $this->settingRepository->findById($id);
        $feeTypes                 = $this->settingRepository->feeTypes;
        $approvalTypes            = $this->settingRepository->approvalTypes;
        $currentRegistrationTypes = explode(',', $setting->registration_types);
        $registrationTypes        = $this->settingRepository->registrationTypes;
        $countries                = $this->countryRepository->getAll()->lists('name', 'id');
        $currentCountries         = $setting->settingable->eventCountries->modelKeys();
        $this->render('admin.settings.edit', compact('setting', 'feeTypes', 'approvalTypes', 'registrationTypes', 'currentRegistrationTypes', 'countries', 'currentCountries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id Setting ID
     * @return Response
     */
    public function update($id)
    {
        $setting = $this->settingRepository->findById($id);

        // check for an invalid registration type
        $registrationTypes = Input::get('registration_types');
        if ( !empty($registrationTypes) ) {
            foreach ( Input::get('registration_types') as $registrationType ) {
                if ( !in_array($registrationType, $this->settingRepository->registrationTypes) ) {
                    return Redirect::back()->with('error', 'Wrong Value ')->withInput();
                }
            }
        }

        $val = $this->settingRepository->getEditForm($id);

        if ( !$val->isValid() ) {
            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( !$this->settingRepository->update($id, $val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->settingRepository->errors())->withInput();
        }
        // update countries
        $event = $setting->settingable;

//        foreach ( Input::get('country_ids') as $countryId ) {
        $event->eventCountries()->sync(Input::get('country_ids'));
//        }

        // If First time the settings are created, then redirect to options page
        if ( Input::get('store') == 'true' ) {
            return Redirect::action('AdminSettingsController@editOptions', $id)->with('success', 'Event Settings Updated');
        }

        return Redirect::action('AdminEventsController@index')->with('success', 'Event Settings Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    /**
     * @param $id
     * Event Id
     * Get Add Online Room ( Form )
     */
    public function getAddRoom($id)
    {
        $setting = $this->settingRepository->findById($id);

        // get the current available registration types for the event from the db
        $registrationTypes = explode(',', $setting->registration_types);

        if ( !in_array('ONLINE', $registrationTypes) ) {
            // if online option is not available, Redirect Back
            return Redirect::action('AdminEventsController@index')->with('error', 'This Event has no Online Feature');
        }

        $this->render('admin.settings.add-room', compact('setting'));
    }

    public function postAddRoom($id)
    {
        $val = $this->settingRepository->getOnlineRoomForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }
        if ( !$this->settingRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->settingRepository->errors())->withInput();
        }

        return Redirect::action('AdminEventsController@index')->with('success', 'Room Added');

    }

    /**
     * @param $id SettingsID
     */
    public function editOptions($id)
    {
        $setting   = $this->settingRepository->findById($id, ['settingable.location.country', 'settingable.eventPrices', 'settingable.eventCountries.price']);
        $event     = $setting->settingable;
        $freeEvent = $event->isFreeEvent();
        $this->render('admin.settings.edit-options', compact('setting', 'event', 'freeEvent'));
    }

    public function updateOptions($id)
    {
        $setting     = $this->settingRepository->findById($id, ['settingable.location.country']);
        $event       = $setting->settingable;
        $validPrices = [];
        $prices      = [];
        $validRegType = [];

        foreach ( Input::all() as $key => $value ) {
            if ( substr($key, 1, 6) == '_price' ) {
                if ( !empty($value) ) {
                    $validPrices[$key] = $value;
                }
            }
        }

        // $validPrices = ['V_price_KW' =>  '222' , 'V_price_AE' => '22' ]
        foreach ( $validPrices as $key => $value ) {
            //find country
            $isoCode = substr($key, 8); // get the country ISO Code frmo the input ex: N_price_KW outputs KW
            $type    = substr($key, 0, 1);
            switch ( $type ) {
                Case 'N' :
                    $type = 'NORMAL';
                    break;
                Case 'O' :
                    $type = 'ONLINE';
                    break;
                Case 'V' :
                    $type = 'VIP';
                    break;
            }


            $country = $this->countryRepository->model->where('iso_code', $isoCode)->first();

            // country Id , // Price // type => N , O
            $countryId = $country->id;

            $prices[] = [$countryId => ['type' => $type, 'price' => $value]];

        }

        if(!empty($prices)) $this->attachPrices($event, $prices, $countryId);

        // update the seats and descroiptions;
        $val = $this->settingRepository->getOptionForm($id);

        if ( !$val->isValid() ) {
            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( !$this->settingRepository->update($id, $val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->settingRepository->errors())->withInput();
        }

        // update available seats
        foreach ( Input::all() as $key => $value ) {
            if (substr($key, -12) == '_total_seats' ) {
                if ( !empty($value) ) {
                    $type = substr($key, 0, -12);  // returns "abcde"
                    $validRegType[$type] = $value;
                }
            }
        }

        // update available seats for all the registration types
        $setting->updateAvailableSeatsBulk($validRegType);

        return Redirect::action('AdminEventsController@index')->with('success', 'Event Settings Updated');

    }

    public function attachPrices($model, array $prices)
    {
        $eventPrices = $model->eventPrices;
        $attachedPrices = $eventPrices->modelKeys();
        if ( !empty($attachedPrices) ) {
            // if there are any tags assosiated with the event
            if ( empty($prices) ) {
                // if no tags in the GET REQUEST, delete all the tags
                foreach ( $attachedPrices as $tag ) {
                    // delete all the tags
                    $model->eventPrices()->detach($tag);
                }
            } else {
                // If the used tags is unselected in the GET REQUEST, delete the tags
                foreach ( $attachedPrices as $tag ) {
                    if ( !in_array($tag, $prices) ) {
                        $model->eventPrices()->detach($tag);
                    }
                }
            }
        }

        foreach ( $prices as $price ) {
            $model->eventPrices()->attach($price);
        }

    }


//    public function attachPrices($model, array $prices, $countryID)
//    {
//        $eventPrices = $model->eventPrices;
////
//        foreach ( $prices as $price ) {
//            $currentPrice = array_pop($price);
//            $eventPrice   = $model->eventPricesByType($countryID, $currentPrice['type'], $currentPrice['price'])->get();
//        }
//
//////
//        $attachedPrices = $eventPrices->modelKeys();
////
//        foreach ( $prices as $price ) {
//            $old_price    = $price;
//            $currentPrice = array_pop($price);
//            //1 - find by type
//            foreach ( $prices as $price ) {
//                $currentPrice = array_pop($price);
//                $eventPrice   = $model->eventPricesByType($currentPrice['type'])->first();
//                if ( $eventPrice ) {
//
//                } else {
//
//                }
//            }
//            //2 - if found update
//            //3 - if not delete
//            dd($old_price);
//            $priceByType = $this->eventPriceRepository->findByType($modelId, $a);
//
//        }
//
////        dd('a');
////        dd($attachedPrices);
//
////        dd($attachedPrices);
////        dd($prices);
////        foreach ( $prices as $price ) {
////
////        }
//
////        $model->eventPricesByType()->sync($attachedPrices);
//
////        dd('done');
//
//    }


}
