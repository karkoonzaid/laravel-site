<?php

class AdminCountriesController extends AdminBaseController {

	/**
	 * Country Repository
	 *
	 * @var Country
	 */
	protected $countryRepository;

	public function __construct(\Acme\Country\CountryRepository $countryRepository)
	{
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
		$countries = $this->countryRepository->getAll();

		$this->render('admin.countries.index', compact('countries'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->render('admin.countries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $val = $this->countryRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->countryRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->countryRepository->errors())->withInput();
        }

        return Redirect::action('AdminCountriesController@index')->with('success','Category Created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$country = $this->countryRepository->findOrFail($id);

		$this->render('admin.countries.show', compact('country'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$country = $this->countryRepository->findById($id);

		if (is_null($country))
		{
			return Redirect::route('countries.index');
		}

		$this->render('admin.countries.edit', compact('country'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->countryRepository->findById($id);

        $val = $this->countryRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->countryRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->countryRepository->errors())->withInput();
        }

        return Redirect::action('AdminCountriesController@index')->with('success', 'Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->countryRepository->findById($id)->delete();

		return Redirect::action('AdminCountriesController@index');
	}

}
