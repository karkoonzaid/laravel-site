<?php

use Acme\Contact\ContactRepository;

class ContactsController extends BaseController {

    /**
     * Contact Repository
     *
     * @var Category
     */
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
        $this->beforeFilter('csrf', ['only' => ['contact']]);
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
        if ( !$contact ) {
            return Redirect::home()->with('warning', trans('general.cannot_contact_admin'));
        }

        $this->title = trans('word.contact_us');
        $this->render('site.layouts.contact', compact('contact'));
    }

    /**
     * Send Contact Email.
     *
     * @return Response
     */
    public function contact()
    {
        // Get the contact info from DB
        $user = $this->contactRepository->getFirst();

        // Validate the input data
        $val = $this->contactRepository->getContactForm();

        if ( !$val->isValid() ) {
            return Redirect::back()->withInput()->with('errors', $val->getErrors());
        }

        $input = array_merge(Input::only(['sender_name', 'sender_email', 'body']), $user->toArray());

        Event::fire('contact.contact', [$input]);

        return Redirect::home()->with('success', trans('word.mail_sent'));
    }
}