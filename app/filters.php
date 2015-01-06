<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
*/

App::before(function ($request) {
    // enforce no www
    if ( preg_match('/^http:\/\/www./', $request->url()) ) {
        $newUrl = preg_replace('/^http:\/\/www./', 'http://', $request->url());

        return Redirect::to($newUrl);
    }
});

App::after(function ($request, $response) {
    if ( Auth::guest() ) {
        if ( !stristr($request->path(), 'login') && !stristr($request->path(), 'signup') ) Session::put('auth.intended_redirect_url', $request->url());
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function () {

    if ( Auth::guest() )
        return Redirect::guest('account/login')->with('info', trans('auth.alerts.must_login'));
});

Route::filter('auth.basic', function () {
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if ( Auth::check() ) return Redirect::action('AuthController@getLogin');
//    if ( Auth::check() ) return Redirect::action('AuthController@getLogin');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if ( Session::getToken() !== Input::get('_token') ) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('Moderator', function () {
    if ( !(Entrust::hasRole('admin') || (Entrust::hasRole('moderator'))) ) // Checks the current user
    {
        return Redirect::to('forbidden')->with('error', 'Sorry You Do not have access to this page');
    }
});

Route::filter('Admin', function () {
    if ( !(Entrust::hasRole('admin')) ) // Checks the current user
    {
        return Redirect::to('forbidden')->with('errors', 'Sorry You Do not have access to this page');
    }
});


Route::filter('owner', function ($route, $request) {
    if ( Auth::check() )
        if ( $request->segment(3) != Auth::user()->id ) {
            return Redirect::action('EventsController@dashboard')->with('error', 'You are not supposed to do that');
        } else {
            return;
        }

    return Redirect::action('UserController@getLogin')->with('error', 'Please login');
});

/**
 * Route filter to allow users who are only not logged in
 */
Route::filter('noAuth', function () {
    if ( Auth::check() ) return Redirect::home();
});


