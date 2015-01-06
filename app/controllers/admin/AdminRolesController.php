<?php

class AdminRolesController extends AdminBaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    /**
     * Permission Model
     * @var Permission
     */
    protected $permission;

    /**
     * Inject the models.
     * @param User $user
     * @param Role $role
     * @param Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
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
        // Title
        $title = Lang::get('admin/roles/title.role_management');


        $roles = Role::select(array('roles.id',  'roles.name', 'roles.id as users', 'roles.created_at'))->get();

        // Show the page
        $this->render('admin.roles/.index', compact('roles', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

        // Title
        $title = Lang::get('admin/roles/title.create_a_new_role');

        // Show the page
       $this->render('admin/roles/create', compact('permissions', 'selectedPermissions', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required'
        );
        $getPermissions = Input::get('permissions');
        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);
        // Check if the form validates with success
        if ($validator->passes())
        {
            // Get the inputs, with some exceptions
            $inputs = Input::except('csrf_token');

            $this->role->name = $inputs['name'];
            $this->role->save();

            // Save permissions
            $perms = $this->permission->get();
            if(count($perms)) {
                if(isset($getPermissions)) {

                    $this->role->perms()->sync($this->permission->preparePermissionsForSave($getPermissions));
                }
            }

            // Was the role created?
            if ($this->role->id)
            {
                // Redirect to the new role page
                return Redirect::to('admin/roles/' . $this->role->id . '/edit')->with('success', Lang::get('admin/roles/messages.create.success'));
            }

            // Redirect to the new role page
            return Redirect::to('admin/roles/create')->with('error', Lang::get('admin/roles/messages.create.error'));

            // Redirect to the role create page
            return Redirect::to('admin/roles/create')->withInput()->with('error', Lang::get('admin/roles/messages.' . $error));
        }

        // Form validation failed
        return Redirect::to('admin/roles/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $role
     * @return Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if(! empty($role))
        {
            $permissions = $this->permission->preparePermissionsForDisplay($role->perms()->get());
        }
        else
        {
            // Redirect to the roles management page
            return Redirect::to('admin.roles')->with('error', Lang::get('admin/roles/messages.does_not_exist'));
        }

        // Title
        $title = Lang::get('admin/roles/title.role_update');

        // Show the page
       $this->render('admin/roles/edit', compact('role', 'permissions', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $role
     * @return Response
     */
    public function update($id)
    {
        $role = Role::find($id);
        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the role data
            $role->name        = Input::get('name');
            $role->perms()->sync($this->permission->preparePermissionsForSave(Input::get('permissions')));

            // Was the role updated?
            if ($role->save())
            {
                // Redirect to the role page
                return Redirect::to('admin/roles/' . $role->id . '/edit')->with('success', Lang::get('admin/roles/messages.update.success'));
            }
            else
            {
                // Redirect to the role page
                return Redirect::to('admin/roles/' . $role->id . '/edit')->with('error', Lang::get('admin/roles/messages.update.error'));
            }
        }

        // Form validation failed
        return Redirect::to('admin/roles/' . $role->id . '/edit')->withInput()->withErrors($validator);
    }


    /**
     * Remove user page.
     *
     * @param $role
     * @return Response
     */
    public function delete($id)
    {
        $role = Role::find($id);
        // Title
        $title = Lang::get('admin/roles/title.role_delete');

        // Show the page
       $this->render('admin/roles/delete', compact('role', 'title'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param $role
     * @internal param $id
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        // Was the role deleted?
            if($role->delete()) {
                // Redirect to the role management page
                return Redirect::to('admin/roles')->with('success', Lang::get('admin/roles/messages.delete.success'));
            }

            // There was a problem deleting the role
            return Redirect::to('admin/roles')->with('error', Lang::get('admin/roles/messages.delete.error'));
    }
}