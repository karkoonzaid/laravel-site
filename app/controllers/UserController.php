<?php

use Acme\Country\CountryRepository;
use Acme\User\UserRepository;
use Illuminate\Support\Facades\Redirect;

class UserController extends BaseController {

    protected $userRepository;

    protected $countryRepository;

    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
    {
        $this->userRepository    = $userRepository;
        $this->countryRepository = $countryRepository;
        parent::__construct();
    }

    public function show($id)
    {
        return $this->getProfile($id);
    }

    /**
     * Edit Profile
     * @param $id
     */
    public function edit($id)
    {
        $user      = $this->userRepository->findById($id);
        $countries = [0 => trans('word.choose_country')] + $this->countryRepository->getAll()->lists('name_ar', 'id');
        $this->render('site.users.edit', compact('user', 'countries'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Update Profile
     */
    public function update($id)
    {
        $this->userRepository->findById($id);

        $val = $this->userRepository->getEditForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( !$this->userRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
        }

        return Redirect::action('UserController@getProfile', $id)->with('success', 'word.saved');
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);

        if ( $this->userRepository->delete($user) ) {

            return Redirect::home()->with('success', 'word.deleted');
        }

        return Redirect::back('/')->with('errors', 'word.error');
    }

    /**
     * Get user's profile
     * @param $id
     * @internal param $username
     * @return mixed
     */
    public function getProfile($id)
    {
        $user = $this->userRepository->findById($id, ['favorites', 'subscriptions', 'followings', 'country']);
        $this->render('site.users.profile', compact('user'));
    }

}
