<?php

use Acme\User\AuthService;
use Acme\User\UserRepository;

class AdminUsersController extends AdminBaseController {


    /**
     * User Model
     * @var User
     */
    protected $userRepository;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    protected $mailer;

    /**
     * Permission Model
     * @var Permission
     */
    protected $permission;

    /**
     * @var AuthService
     */
    private $authService;

    /**
     * Inject the models.
     * @param UserRepository|User $userRepository
     * @param Role $role
     * @param Permission $permission
     * @param AuthService $authService
     */
    public function __construct(UserRepository $userRepository, Role $role, Permission $permission, AuthService $authService)
    {

        $this->userRepository = $userRepository;
        $this->role           = $role;
        $this->permission     = $permission;
        $this->beforeFilter('Admin', array('except' => array('index', 'getIndex', 'view', 'getReport', 'postReport', 'getData')));
        parent::__construct();
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the users
        $title  = 'Users';
        $users = $this->userRepository->getAllPaginated(['roles','country'],800);
        // Show the page
        return $this->render('admin.users.index', compact('users', 'title'));
    }

    public function show($id)
    {
        $user= $this->userRepository->findById($id);
        $title = $user->name .' Profile';
        return $this->render('admin.users.show', compact('user','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // All roles
        $roles = $this->role->all();

        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected groups
        $selectedRoles = Input::old('roles', array());

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

        // Title
        $title = Lang::get('admin/users/title.create_a_new_user');

        // Mode
        $mode = 'create';

        // Show the page
        $this->render('admin/users/create', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // Validate the inputs

        // get the registration form
        $val = $this->userRepository->getAdminCreateForm();

        // check if the form is valid
        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $user = $this->userRepository->model->where('email','z4ls@live.com')->first();
        // If Auth Sevice Fails to Register the User
        if ( !$user = $this->authService->register($val->getInputData()) ) {

            return Redirect::home()->with('errors', $this->userRepository->errors());
        }
        // Save roles. Handles updating.
        $roles = is_array(Input::get('roles')) ? Input::get('roles') : [];

        //get the user that was just addded ;
        $user = $this->userRepository->model->where('email',Input::get('email'))->first();
        $user->saveRoles($roles);

        // Redirect to the new user page
        return Redirect::action('AdminUsersController@index')->with('success', Lang::get('admin/users/messages.create.success'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        if ( $user ) {
            $roles       = $this->role->all();
            $permissions = $this->permission->all();

            // Title
            $title = Lang::get('admin/users/title.user_update');
            // mode
            $mode = 'edit';

            $this->render('admin.users.edit', compact('user', 'roles', 'permissions', 'title', 'mode'));
        } else {
            return Redirect::to('admin.users')->with('error', Lang::get('admin.users.messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * @internal param $user
     * @return Response
     */
    public function update($id)
    {
        $user = $this->userRepository->findById($id);
        // Validate the inputs

        $val = $this->userRepository->getAdminEditForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( !$this->userRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
        }


        $roles = is_array(Input::get('roles')) ? Input::get('roles') : [];
        $user->saveRoles($roles);

        // If user activate status have changed;
        if ( $user->active != Input::get('active') ) {
            $this->authService->changeActivateStatus($user);
        }

        return Redirect::action('AdminUsersController@index')->with('success', 'Updated user');
    }

    /**
     * Remove user page.
     *
     * @param $user
     * @return Response
     */
    public function delete($id)
    {
        $user = $this->userRepository->findById($id);
        // Title
        $title = Lang::get('admin.users.title.user_delete');

        // Show the page
        $this->render('admin.users.delete', compact('user', 'title'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param $user
     * @return Response
     */
    public function destroy($id)
    {

        // Check if we are not trying to delete ourselves
        if ( $id === Auth::user()->id ) {
            // Redirect to the user management page
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.impossible'));
        }

        if ( $this->userRepository->findById($id)->delete() ) {
            return Redirect::action('AdminUsersController@index')->with('success', 'Deleted');
        }

        return Redirect::action('AdminUsersController@index')->with('error', 'Could not Delete');

    }


    public function getReport($id)
    {
        $title = 'Report This User to Admin';
        $user  = $this->userRepository->find($id);
        $this->render('admin.users.report', compact('user', 'title'));
    }

    public function postReport($id)
    {
        $args                         = Input::all();
        $report_user                  = $this->userRepository->find($id);
        $user                         = Contact::first(); // admin
        $args['email']                = Auth::user()->email;
        $args['name']                 = Auth::user()->username;
        $args['report_user_email']    = $report_user->email;
        $args['report_user_username'] = $report_user->username;
        $rules                        = array(
            'subject' => 'required',
            'body'    => 'required|min:5'
        );
        $validate                     = Validator::make($args, $rules);
        if ( $validate->passes() ) {
            if ( $this->mailer->sendMail($user, $args) ) {
                return parent::redirectToAdmin()->with('success', 'Mail Sent');
            }

            return parent::redirectToUser()->with('error', 'Error Sending Mail');
        }

        return Redirect::back()->withInput()->with('error', $validate->errors()->all());
    }

    public function printDetail($id)
    {

        $user = $this->userRepository->findById($id);

        $pdf = PDF::loadView('admin.users.detail', compact('user'));

        return $pdf->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream(str_random(10) . '.pdf');
//        return View::make('admin.users.detail',compact('user'));

    }

}
