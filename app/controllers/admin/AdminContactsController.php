<?php

use Acme\Contact\ContactRepository;

class AdminContactsController extends AdminBaseController {

    /**
     * Contact Repository
     *
     * @var Category
     */
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->beforeFilter('Admin');
        $this->contactRepository = $contactRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contact = $this->contactRepository->getFirst();
        $this->render('admin.contacts.create', compact('contact'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $val = $this->contactRepository->getCreateForm();

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $contact = $this->contactRepository->getFirst();

        if ( $contact ) {
            if ( !$this->contactRepository->update($contact->id, $val->getInputData()) ) {

                return Redirect::back()->with('errors', $this->contactRepository->errors())->withInput();
            }

        } else {
            if ( !$this->contactRepository->create($val->getInputData()) ) {
                return Redirect::back()->with('errors', $this->contactRepository->errors())->withInput();
            }

        }
        return Redirect::action('AdminContactsController@index')->with('success', 'Saved');


    }
}