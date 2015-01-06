<?php namespace Acme\User;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Acme\User\Validators\AdminCreateValidator;
use Acme\User\Validators\AdminUpdateValidator;
use Acme\User\Validators\ResetValidator;
use DB;
use Illuminate\Support\MessageBag;
use User;


class UserRepository extends BaseRepository  {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Acme\Users\User|\Illuminate\Database\Eloquent\Model|\User $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(User $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;

    }

    public function getRoleByName($roleName) {
        $query=  $this->model->with('roles')->whereHas('roles', function($q) use ($roleName)
        {
            $q->where('name', '=', $roleName);

        })->get();
        return $query;
    }

    public function getPasswordResetForm()
    {
        return new ResetValidator();
    }

    public function findByToken($token){
        return $this->model->whereConfirmationCode($token)->first();
    }

    public function findByEmail($email) {
        return $this->model->whereEmail($email)->first();
    }

    public function findUsersForIndex(){
        $users = DB::table('users')->leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->select(array('users.*', 'roles.name as rolename'))
            ->groupBy('users.email')->get();
        return $users;
    }

    public function getAdminEditForm($id){
        return new AdminUpdateValidator($id);
    }
    public function getAdminCreateForm(){
        return new AdminCreateValidator();
    }

    public function getCountryByIso($isoCode){
        return $this->model->country;
    }
}