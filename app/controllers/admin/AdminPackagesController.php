<?php

use Acme\Package\PackageRepository;
use Acme\Setting\SettingRepository;

class AdminPackagesController extends AdminBaseController {


    /**
     * @var Acme\EventModel\PackageRepository
     */
    private $packageRepository;
    /**
     * @var Acme\Setting\SettingRepository
     */
    private $settingRepository;

    function __construct(PackageRepository $packageRepository, SettingRepository $settingRepository)
    {
        parent::__construct();
        $this->packageRepository = $packageRepository;
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

    }

    public function show($id){
        $packages = $this->packageRepository->findById($id);
        foreach ( $packages->events as $package ) {
            foreach ( $package->subscriptions as $p ) {
                dd($p);
            }
        }


//        $package = EventModel::find($id);
//        dd($package->events->subscriptions );
//        dd($package);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->render('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        $val = $this->packageRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $package = $this->packageRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->packageRepository->errors())->withInput();
        }

        if ( ! $setting = $this->settingRepository->create(['settingable_type' => 'Package', 'settingable_id' => $package->id]) ) {
            $this->eventRepository->delete($package);
            //@todo redirect
            dd('could not create event');
        }

        // Create a settings record for the inserted event
        // Settings Record needs to know Which type of Record and The Foreign Key it needs to Create
        // So pass these fields with Session (settableType,settableId)

        return Redirect::action('AdminSettingsController@edit',$setting->id);
    }

    public function edit($id)
    {
        $package         = $this->packageRepository->findById($id);
//        dd($package->toArray());
        $this->render('admin.packages.edit',compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $this->packageRepository->findById($id);

        $val = $this->packageRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if (! $this->packageRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->packageRepository->errors())->withInput();
        }

        return Redirect::action('AdminPackagesController@edit', $id)->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $package = $this->packageRepository->findById($id);

        if ( $this->packageRepository->delete($package) ) {
            //  return Redirect::home();
            return Redirect::action('AdminEventsController@index')->with('success', 'Package Deleted');
        }

        return Redirect::action('AdminEventsController@index')->with('error', 'Error: Package Not Found');
    }

    public function  settings($id){

    }

}
