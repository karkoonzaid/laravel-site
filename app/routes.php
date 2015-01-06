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
    $a = [
        'home'                      => 'Home',
        'admin'                     => 'Admin',
        'login'                     => 'Login',
        'logout'                    => 'request_reorganize_events',
        'register'                  => 'request_reorganize_events',
        'main'                      => 'request_reorganize_events',
        'consultancies'             => 'request_reorganize_events',
        'blog'                      => 'request_reorganize_events',
        'contact_us'                => 'request_reorganize_events',
        'search'                    => 'request_reorganize_events',
        'username'                  => 'request_reorganize_events',
        'password'                  => 'request_reorganize_events',
        'email'                     => 'request_reorganize_events',
        'package_events'            => 'request_reorganize_events',
        'event_summary'             => 'request_reorganize_events',
        'total_seats'               => 'request_reorganize_events',
        'date_start'                => 'request_reorganize_events',
        'starting'                  => 'request_reorganize_events',
        'seats_available'           => 'request_reorganize_events',
        'date_end'                  => 'request_reorganize_events',
        'time_end'                  => 'request_reorganize_events',
        'cancel'                    => 'request_reorganize_events',
        'comments'                  => 'request_reorganize_events',
        'add_comment'               => 'request_reorganize_events',
        'category'                  => 'request_reorganize_events',
        'title'                     => 'request_reorganize_events',
        'events'                    => 'request_reorganize_events',
        'all'                       => 'request_reorganize_events',
        'choose_country'            => 'request_reorganize_events',
        'choose_category'           => 'request_reorganize_events',
        'choose_author'             => 'request_reorganize_events',
        'price'                     => 'request_reorganize_events',
        'free'                      => 'request_reorganize_events',
        'kaizen'                    => 'request_reorganize_events',
        'email'                     => 'request_reorganize_events',
        'submit'                    => 'request_reorganize_events',
        'comment'                   => 'request_reorganize_events',
        'remember'                  => 'request_reorganize_events',
        'latest_events'             => 'request_reorganize_events',
        'latest_blog'               => 'request_reorganize_events',
        'newsletter'                => 'request_reorganize_events',
        'instagram'                 => 'request_reorganize_events',
        'twitter'                   => 'request_reorganize_events',
        'youtube'                   => 'request_reorganize_events',
        'profile'                   => 'request_reorganize_events',
        'username'                  => 'request_reorganize_events',
        'password'                  => 'request_reorganize_events',
        'mobile'                    => 'request_reorganize_events',
        'country_code'              => 'request_reorganize_events',
        'password_confirmation'     => 'request_reorganize_events',
        'telelphone'                => 'request_reorganize_events',
        'select_country'            => 'request_reorganize_events',
        'countrycode'               => 'request_reorganize_events',
        'birthdate'                 => 'request_reorganize_events',
        'gender'                    => 'request_reorganize_events',
        'male'                      => 'request_reorganize_events',
        'female'                    => 'request_reorganize_events',
        'more'                      => 'request_reorganize_events',
        'not_available'             => 'request_reorganize_events',
        'phone'                     => 'request_reorganize_events',
        'country'                   => 'request_reorganize_events',
        'location'                  => 'request_reorganize_events',
        'admin_panel'               => 'request_reorganize_events',
        'subscribe'                 => 'request_reorganize_events',
        'unsubscribe'               => 'request_reorganize_events',
        'follow_event'              => 'request_reorganize_events',
        'favorites'                 => 'request_reorganize_events',
        'settings'                  => 'request_reorganize_events',
        'address'                   => 'request_reorganize_events',
        'vip'                       => 'request_reorganize_events',
        'online'                    => 'request_reorganize_events',
        'normal'                    => 'request_reorganize_events',
        'system_error'              => 'request_reorganize_events',
        'no_results'                => 'request_reorganize_events',
        'keyword'                   => 'request_reorganize_events',
        'search_keywords'           => 'request_reorganize_events',
        'subscriptions'             => 'request_reorganize_events',
        'followings'                => 'request_reorganize_events',
        'kaizenyc'                  => 'request_reorganize_events',
        'kaizen'                    => 'request_reorganize_events',
        'comment_posted'            => 'request_reorganize_events',
        'name_en'                   => 'request_reorganize_events',
        'save'                      => 'request_reorganize_events',
        'suggested_events'          => 'request_reorganize_events',
        'payment_options'           => 'request_reorganize_events',
        'total'                     => 'request_reorganize_events',
        'pay_with_payapl'           => 'request_reorganize_events',
        'success'                   => 'request_reorganize_events',
        'warning'                   => 'request_reorganize_events',
        'error'                     => 'request_reorganize_events',
        'info'                      => 'request_reorganize_events',
        'edit'                      => 'request_reorganize_events',
        'delete'                    => 'request_reorganize_events',
        'enter'                     => 'request_reorganize_events',
        'register'                  => 'request_reorganize_events',
        'more'                      => 'request_reorganize_events',
        'title'                     => 'request_reorganize_events',
        'description'               => 'request_reorganize_events',
        'forgot_password'           => 'request_reorganize_events',
        'remember'                  => 'request_reorganize_events',
        'submit'                    => 'request_reorganize_events',
        'previous'                  => 'request_reorganize_events',
        'next'                      => 'request_reorganize_events',
        'password_confirmation'     => 'request_reorganize_events',
        'mail_sent'                 => 'request_reorganize_events',
        'event_expired'             => 'request_reorganize_events',
        'token_expired'             => 'request_reorganize_events',
        'invalid_token'             => 'request_reorganize_events',
        'profile_updated'           => 'request_reorganize_events',
        'saved'                     => 'request_reorganize_events',
        'created'                   => 'request_reorganize_events',
        'deleted'                   => 'request_reorganize_events',
        'updated'                   => 'request_reorganize_events',
        'create_new_account'        => 'request_reorganize_events',
        'hello'                     => 'request_reorganize_events',
        'click_here'                => 'request_reorganize_events',
        'expired_events'            => 'request_reorganize_events',
        'view_all_expired_events'   => 'request_reorganize_events',
        'name'                      => 'request_reorganize_events',
        'contact'                   => 'request_reorganize_events',
        'welcome_to_kaizen'         => 'request_reorganize_events',
        'price'                     => 'request_reorganize_events',
        'free_event'                => 'request_reorganize_events',
        'to'                        => 'request_reorganize_events',
        'enter_event_room'          => 'request_reorganize_events',
        'tags'                      => 'request_reorganize_events',
        'request_reorganize_events' => 'request_reorganize_events'
    ];

    foreach($a as $key=>$value) {
        echo "'".$key."'=>'".ucfirst(str_replace('_',' ',$key))."',<br>";
    }
});