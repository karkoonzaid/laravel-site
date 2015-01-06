<?php

use Acme\Ad\AdRepository;
use Acme\Photo\PhotoRepository;

class AdminAdsController extends AdminBaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $model;
    /**
     * @var Photo
     */
    protected $photoRepository;
    /**
     * @var AdRepository
     */
    private $adRepository;

    /**
     * @param AdRepository $adRepository
     * @param PhotoRepository $photoRepository
     */
    public function __construct(AdRepository $adRepository, PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
        $this->adRepository = $adRepository;
        parent::__construct();
        $this->beforeFilter('Admin');
    }

    public function index()
    {
        $ads = $this->adRepository->getAll(['photos']);
        return $this->render('admin.ads.index', compact('ads'));
    }

    /**
     * Get Ads For view
     * Get Two Ads, whose status is active, sort by uploaded date
     */
    public function getAds() {
        $ads = $this->adRepository->getAds();
        return $ads;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Title
        // Show the page
        $this->render('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $val = $this->adRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->adRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->adRepository->errors())->withInput();
        }

        return Redirect::action('AdminAdsController@index')->with('success','Created Ad');

    }


    public function edit($id)
    {
        $ad     = $this->adRepository->findById($id);

        // Show the page
        $this->render('admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function update($id)
    {
        $this->adRepository->findById($id);

        $val = $this->adRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->adRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->adRepository->errors())->withInput();
        }

        return Redirect::action('AdminAdsController@index')->with('success', 'Updated');
    }


    public function delete($id)
    {
        $post = $this->adRepository->find($id);
        // Title
        // Show the page
        $this->render('admin.blogs.delete', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @internal param $post
     * @return Response
     */

    public function destroy($id)
    {
        if ($this->adRepository->findById($id)->delete()) {

            return Redirect::action('AdminAdsController@index')->with('success','Deleted');
        }
        return Redirect::action('AdminAdsController@index')->with('error','Could not Delete');

    }

    public function updateActive($id){

        $ad = $this->adRepository->findById($id);
        $ad->active = Input::get('active');

        if($ad->save()){
            return Redirect::action('AdminAdsController@index')->with('success','Updated');
        }
        return Redirect::action('AdminAdsController@index')->with('error','Could not Update');

    }
}