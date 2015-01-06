<?php

use Acme\Photo\ImageService;
use Acme\Photo\PhotoRepository;
use Illuminate\Support\Facades\Redirect;

class AdminPhotosController extends AdminBaseController {

    private $photoRepository;

    private $photoImageService;

    function __construct(PhotoRepository $photoRepository, ImageService $photoImageService)
    {
        $this->photoRepository   = $photoRepository;
        $this->photoImageService = $photoImageService;
        parent::__construct();
    }

    public function create()
    {
        $imageableType = Input::get('imageable_type');
        $imageableId   = Input::get('imageable_id');
        if ( empty($imageableType) || empty($imageableId))  {
            return Redirect::action('AdminEventsController@index')->with('warning','Wrong Access');
        }

        $this->render('admin.photos.create', compact('imageableType', 'imageableId'));
    }

    /**
     * Non Ajax Version
     */
    public function createNormal()
    {
        $imageableType = Input::get('imageable_type');
        $imageableId   = Input::get('imageable_id');
        if ( empty($imageableType) || empty($imageableId))  {
            return Redirect::action('AdminEventsController@index')->with('warning','Wrong Access');
        }

        $this->render('admin.photos.create-normal', compact('imageableType', 'imageableId'));
    }
    /**
     * Store the Image
     * Resolve the Dependent class for polymorphic relation
     *
     */
    public function store()
    {
        $val           = $this->photoRepository->getCreateForm();
        $imageableType = Input::get('imageable_type');

        if ( ! $val->isValid() ) {

            if ( Request::ajax() ) return false;

            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }
        // resolve the class .. imageabele_type is the class name
        $imageService = App::make('Acme\\' . $imageableType . '\\ImageService');

        // uplad the file to the server
        $upload = $imageService->store(Input::file('name'));

        if ( ! $upload ) {
            // when photos are uploaded using ajax
            if ( Request::ajax() ) return false;

            // if not ajax, redirect
            return Redirect::back()->withInput()->with('errors', $imageService->errors());
        }

        // save image in the database
        try {
            $this->photoRepository->create(array_merge(['name' => $upload->getHashedName()], $val->getInputData()));
        }
        catch ( \Exception $e ) {

            // if something goes wrong, and cant save the photo in the database
            // then delete the files from the server
            $upload->destroy($upload->getHashedName());

            return Redirect::back()->withInput()->with('error', 'Sorry, Could Not Save the Image info in the database');
        }

        if ( Request::ajax() ) return null;

        return Redirect::back()->with('success', 'photo saved');

    }

    /**
     * @param $id Photo ID
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($id)
    {
        $photo = $this->photoRepository->findById($id);
        if ( $photo->delete() ) {

            $this->photoImageService->destroy($photo->name);

            return Redirect::back()->with('success', 'Photo Deleted');
        }

        return Redirect::back()->with('error', 'Error: Photo Not Found');
    }


}
