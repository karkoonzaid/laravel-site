<?php

Route::pattern('id', '[0-9]+');

Route::pattern('token', '[0-9a-z]+');

/*********************************************************************************************************
 * Event Routes
 ********************************************************************************************************/
Route::get('event/{id}/online', 'EventsController@streamEvent');

Route::get('event/{id}/offline', 'EventsController@streamEventOld');

Route::get('event/{id}/category', 'EventsController@getCategory');

Route::get('event/{id}/author', 'EventsController@getAuthor');

Route::get('event/{id}/follow', array('as' => 'event.follow', 'uses' => 'EventsController@follow'));

Route::get('event/{id}/unfollow', array('as' => 'event.unfollow', 'uses' => 'EventsController@unfollow'));

Route::get('event/{id}/favorite', array('as' => 'event.favorite', 'uses' => 'EventsController@favorite'));

Route::get('event/{id}/unfavorite', array('as' => 'event.unfavorite', 'uses' => 'EventsController@unfavorite'));

Route::get('events/featured', array('as' => 'event.featured', 'uses' => 'EventsController@getSliderEvents'));

Route::get('event/{id}/country', 'EventsController@getCountry');

Route::get('event/{id}/options', 'EventsController@showSubscriptionOptions');

Route::get('event/{id}/suggest', 'EventsController@getSuggestedEvents');

Route::post('event/{id}/organize', 'EventsController@reorganizeEvents');

Route::get('event/{id}/organize', 'EventsController@reorganizeEvents');

Route::get('online-event', 'EventsController@onlineTestEvent');

Route::resource('event.comments', 'CommentsController', array('only' => array('store')));

Route::resource('event', 'EventsController', array('only' => array('index', 'show')));

/*********************************************************************************************************
 * Subscription Route
 ********************************************************************************************************/
Route::get('package', 'SubscriptionsController@subscribePackage');

Route::post('subscribe', 'SubscriptionsController@subscribe');

Route::get('subscribe', 'SubscriptionsController@subscribe');

Route::get('event/{id}/confirm', 'SubscriptionsController@confirmSubscription');

Route::get('event/{id}/unsubscribe', 'SubscriptionsController@unsubscribe');

/*********************************************************************************************************
 * Payment
 ********************************************************************************************************/
Route::get('event/{id}/payment/options', 'PaymentsController@getPayment');

Route::post('payment', 'PaymentsController@postPayment');

Route::get('payment/final', 'PaymentsController@getFinal');

/*********************************************************************************************************
 * Contact Us Route
 ********************************************************************************************************/
Route::resource('contact', 'ContactsController', array('only' => array('index')));

Route::post('contact/contact', 'ContactsController@contact');

/*********************************************************************************************************
 * Posts
 ********************************************************************************************************/
Route::get('consultancy', array('as' => 'consultancy', 'uses' => 'BlogsController@consultancy'));

Route::resource('blog', 'BlogsController', array('only' => array('index', 'show', 'view')));

/*********************************************************************************************************
 * Tags
 ********************************************************************************************************/
Route::get('tag/{id}/event', 'TagsController@getEvents' );

Route::get('tag/{id}/blog', 'TagsController@getBlogs' );

Route::resource('tag', 'TagsController', array('only' => array('show')));

/*********************************************************************************************************
 * Auth Routes
 ********************************************************************************************************/
Route::get('account/login', ['as' => 'user.login.get', 'uses' => 'AuthController@getLogin']);

Route::post('account/login', ['as' => 'user.login.post', 'uses' => 'AuthController@postLogin']);

Route::get('account/logout', ['as' => 'user.logout', 'uses' => 'AuthController@getLogout']);

Route::get('account/signup', ['as' => 'user.register.get', 'uses' => 'AuthController@getSignup']);

Route::post('account/signup', ['as' => 'user.register.post', 'uses' => 'AuthController@postSignup']);

Route::get('account/forgot', ['as' => 'user.forgot.get', 'uses' => 'AuthController@getForgot']);

Route::post('account/forgot', ['as' => 'user.forgot.post', 'uses' => 'AuthController@postForgot']);

Route::get('password/reset/{token}', ['as' => 'user.token.get', 'uses' => 'AuthController@getReset']);

Route::post('password/reset', ['as' => 'user.token.post', 'uses' => 'AuthController@postReset']);

Route::get('account/activate/{token}', ['as' => 'user.token.confirm', 'uses' => 'AuthController@activate']);

Route::post('account/send-activation-link', ['as' => 'user.token.send-activation', 'uses' => 'AuthController@sendActivationLink']);


/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/
Route::get('user/{id}/profile', array('as' => 'profile', 'uses' => 'UserController@getProfile'));

Route::resource('user', 'UserController');

/*********************************************************************************************************
 * Category Routes
 ********************************************************************************************************/
Route::get('category/{id}/event', array('as' => 'CategoryEvents', 'uses' => 'CategoriesController@getEvents'));

Route::get('category/{id}/blog', array('as' => 'CategoryPosts', 'uses' => 'CategoriesController@getPosts'));

/*********************************************************************************************************
 * Newsletter Routes
 ********************************************************************************************************/
Route::post('newsletter/subscribe', 'NewslettersController@subscribe');

//Route::get('newsletter', 'NewslettersController@index');

/*********************************************************************************************************
 * MISC ROUTES
 ********************************************************************************************************/
Route::get('forbidden', function () {
    return View::make('error.forbidden');
});

Route::get('country/{country}', 'LocaleController@setCountry');

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

/*********************************************************************************************************
 * Admin Routes
 ********************************************************************************************************/
Route::group(array('prefix' => 'admin', 'before' => array('Auth', 'Moderator')), function () {

    /*********************************************************************************************************
     * Admin Comments Routes
     ********************************************************************************************************/
    Route::resource('comments', 'AdminCommentsController');

    /*********************************************************************************************************
     * Admin Blog Management Routes
     ********************************************************************************************************/
    Route::get('blogs/{id}/delete', 'AdminBlogsController@getDelete');

    Route::get('blogs/data', 'AdminBlogsController@getData');

    Route::resource('blogs', 'AdminBlogsController');

    /*********************************************************************************************************
     * User Management Routes
     ********************************************************************************************************/
    Route::get('users/{user}/show', array('uses' => 'AdminUsersController@getShow'));

    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');

    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');

    Route::get('users/{id}/report', 'AdminUsersController@getReport');

    Route::post('users/{id}/report', 'AdminUsersController@postReport');

    Route::get('users/{id}/print', 'AdminUsersController@printDetail');

    Route::resource('users', 'AdminUsersController');

    /*********************************************************************************************************
     * Admin User Role Management Routes
     ********************************************************************************************************/
    Route::resource('roles', 'AdminRolesController');

    /*********************************************************************************************************
     * Admin Events Routes
     ********************************************************************************************************/
    Route::get('event/{id}/followers', 'AdminEventsController@getFollowers');

    Route::get('event/{id}/favorites', 'AdminEventsController@getFavorites');

    Route::get('event/{id}/subscriptions', 'AdminEventsController@getSubscriptions');

    Route::get('event/{id}/country', 'AdminEventsController@getCountry');

    Route::get('event/{id}/location', 'AdminEventsController@getLocation');

    Route::get('event/{id}/mail-followers', 'AdminEventsController@getMailFollowers');

    Route::post('event/{id}/mail-followers', 'AdminEventsController@postMailFollowers');

    Route::get('event/{id}/mail-subscribers', 'AdminEventsController@getMailSubscribers');

    Route::post('event/{id}/mail-subscribers', 'AdminEventsController@postMailSubscribers');

    Route::get('event/{id}/mail-favorites', 'AdminEventsController@getMailFavorites');

    Route::post('event/{id}/mail-favorites', 'AdminEventsController@postMailFavorites');

    Route::get('event/{id}/location', 'AdminEventsController@getLocation');

    Route::get('event/{id}/settings', 'AdminEventsController@getSettings');

    Route::get('event/{id}/details', 'AdminEventsController@getDetails');

    Route::get('event/{id}/requests', array('uses' => 'AdminEventsController@getRequests'));

    Route::get('event/type/create', 'AdminEventsController@selectType');

    Route::resource('event', 'AdminEventsController');

    /*********************************************************************************************************
     * Package routes
     ********************************************************************************************************/
    Route::get('package/{id}/settings', 'AdminPackagesController@settings');

    Route::resource('package', 'AdminPackagesController');

    /*********************************************************************************************************
     * Event Settings Routes
     ********************************************************************************************************/
    Route::get('setting/{id}/add-online-room', 'AdminSettingsController@getAddRoom');

    Route::get('settings/{id}/options/edit', 'AdminSettingsController@editOptions');

    Route::post('settings/{id}/options/edit', 'AdminSettingsController@updateOptions');

    Route::post('setting/{id}/add-online-room', 'AdminSettingsController@postAddRoom');

    Route::resource('settings', 'AdminSettingsController');

    /*********************************************************************************************************
     * Category Routes
     ********************************************************************************************************/
    Route::resource('category', 'AdminCategoriesController');

    /*********************************************************************************************************
     * Country Routes
     ********************************************************************************************************/
    Route::resource('country', 'AdminCountriesController');

    /*********************************************************************************************************
     * Location Routes
     ********************************************************************************************************/
    Route::get('location/{id}/events', array('as' => 'LocationEvents', 'uses' => 'AdminLocationsController@getEvents'));

    Route::resource('locations', 'AdminLocationsController');

    /*********************************************************************************************************
     * Tag Routes
     ********************************************************************************************************/
    Route::resource('tags', 'AdminTagsController');

    /*********************************************************************************************************
     * Ads Route
     ********************************************************************************************************/
    Route::post('ads/{id}/update-active', 'AdminAdsController@updateActive');

    Route::resource('ads', 'AdminAdsController');

    /*********************************************************************************************************
     * Contact US Routes
     ********************************************************************************************************/
    Route::resource('contact-us', 'AdminContactsController', array('only' => array('index', 'store')));

    /*********************************************************************************************************
     * Photo Routes
     ********************************************************************************************************/
    Route::get('photo-normal', 'AdminPhotosController@createNormal');

    Route::resource('photo', 'AdminPhotosController');

    /*********************************************************************************************************
     * Event Requests Route
     ********************************************************************************************************/
    Route::resource('subscription', 'AdminSubscriptionsController');

    /*********************************************************************************************************
     * Payment Routes
     ********************************************************************************************************/
    Route::resource('payment', 'AdminPaymentsController');

    /*********************************************************************************************************
     * Refunds
     ********************************************************************************************************/
    Route::resource('refund', 'AdminRefundsController');

    /*********************************************************************************************************
     * Event Type Routes
     ********************************************************************************************************/
    Route::resource('type', 'AdminTypesController');

    /*********************************************************************************************************
     * Admin Dashboard
     ********************************************************************************************************/
    Route::get('/', 'AdminEventsController@index');

});

/*********************************************************************************************************
 * Iron Queue Workers
 ********************************************************************************************************/
Route::post('queue/iron', function () {
    return Queue::marshal();
});

/*********************************************************************************************************
 * Test Routes
 ********************************************************************************************************/
Route::get('test', function () {
});