<?php

use Acme\Country\CountryRepository;
use Acme\Location\LocationRepository;
use Acme\User\UserRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AdminLocationsController extends AdminBaseController {

    protected $locationRepository;
    protected $countryRepository;
    protected $userRepository;
    public function __construct(LocationRepository $locationRepository, UserRepository $userRepository, CountryRepository $countryRepository) {
        $this->locationRepository = $locationRepository;
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->beforeFilter('Admin');
        parent::__construct();
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $locations = $this->locationRepository->getAll();
        return $this->render('admin.locations.index',compact('locations'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $countries = $this->countryRepository->model->lists('name_en','id');
        return $this->render('admin.locations.create',compact('countries'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $val = $this->locationRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->locationRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->locationRepository->errors())->withInput();
        }

        return Redirect::action('AdminLocationsController@index')->with('success','Category Created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $location = $this->locationRepository->findOrFail($id);

        return $this->render('admin.locations.show', compact('location'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $location = $this->locationRepository->findById($id);
        $countries = $this->select + $this->countryRepository->getList('name_ar');
        return $this->render('admin.locations.edit',compact('location','countries'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->locationRepository->findById($id);

        $val = $this->locationRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->locationRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->locationRepository->errors())->withInput();
        }

        return Redirect::action('AdminLocationsController@index')->with('success', 'Updated');
    }



    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->locationRepository->findById($id)->delete();
        return Redirect::action('AdminLocationsController@index');
	}

    public function getEvents($id){
        $events = Location::find($id)->events;
        return $events;
    }
}
