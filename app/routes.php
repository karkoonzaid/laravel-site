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

Route::resource('event.comments', 'CommentsController', array('only' => array('store')));

Route::get('online-event', 'EventsController@onlineTestEvent');

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

// Post Comment

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
    $array =[
        "44"=>"UK (+44)",
        "1"=>"USA (+1)",
        "213"=>"Algeria (+213)",
        "376"=>"Andorra (+376)",
        "244"=>"Angola (+244)",
        "1264"=>"Anguilla (+1264)",
        "1268"=>"Antigua &amp; Barbuda (+1268)",
        "599"=>"Antilles (Dutch)+599)",
        "54"=>"Argentina (+54)",
        "374"=>"Armenia (+374)",
        "297"=>"Aruba (+297)",
        "247"=>"Ascension Island (+247)",
        "61"=>"Australia (+61)",
        "43"=>"Austria (+43)",
        "994"=>"Azerbaijan (+994)",
        "1242"=>"Bahamas (+1242)",
        "973"=>"Bahrain (+973)",
        "880"=>"Bangladesh (+880)",
        "1246"=>"Barbados (+1246)",
        "375"=>"Belarus (+375)",
        "32"=>"Belgium (+32)",
        "501"=>"Belize (+501)",
        "229"=>"Benin (+229)",
        "1441"=>"Bermuda (+1441)",
        "975"=>"Bhutan (+975)",
        "591"=>"Bolivia (+591)",
        "387"=>"Bosnia Herzegovina (+387)",
        "267"=>"Botswana (+267)",
        "55"=>"Brazil (+55)",
        "673"=>"Brunei (+673)",
        "359"=>"Bulgaria (+359)",
        "226"=>"Burkina Faso (+226)",
        "257"=>"Burundi (+257)",
        "855"=>"Cambodia (+855)",
        "237"=>"Cameroon (+237)",
        "1"=>"Canada (+1)",
        "238"=>"Cape Verde Islands (+238)",
        "1345"=>"Cayman Islands (+1345)",
        "236"=>"Central African Republic (+236)",
        "56"=>"Chile (+56)",
        "86"=>"China (+86)",
        "57"=>"Colombia (+57)",
        "269"=>"Comoros (+269)",
        "242"=>"Congo (+242)",
        "682"=>"Cook Islands (+682)",
        "506"=>"Costa Rica (+506)",
        "385"=>"Croatia (+385)",
        "53"=>"Cuba (+53)",
        "90392"=>"Cyprus North (+90392)",
        "357"=>"Cyprus South (+357)",
        "42"=>"Czech Republic (+42)",
        "45"=>"Denmark (+45)",
        "2463"=>"Diego Garcia (+2463)",
        "253"=>"Djibouti (+253)",
        "1809"=>"Dominica (+1809)",
        "1809"=>"Dominican Republic (+1809)",
        "593"=>"Ecuador (+593)",
        "20"=>"Egypt (+20)",
        "353"=>"Eire (+353)",
        "503"=>"El Salvador (+503)",
        "240"=>"Equatorial Guinea (+240)",
        "291"=>"Eritrea (+291)",
        "372"=>"Estonia (+372)",
        "251"=>"Ethiopia (+251)",
        "500"=>"Falkland Islands (+500)",
        "298"=>"Faroe Islands (+298)",
        "679"=>"Fiji (+679)",
        "358"=>"Finland (+358)",
        "33"=>"France (+33)",
        "594"=>"French Guiana (+594)",
        "689"=>"French Polynesia (+689)",
        "241"=>"Gabon (+241)",
        "220"=>"Gambia (+220)",
        "7880"=>"Georgia (+7880)",
        "49"=>"Germany (+49)",
        "233"=>"Ghana (+233)",
        "350"=>"Gibraltar (+350)",
        "30"=>"Greece (+30)",
        "299"=>"Greenland (+299)",
        "1473"=>"Grenada (+1473)",
        "590"=>"Guadeloupe (+590)",
        "671"=>"Guam (+671)",
        "502"=>"Guatemala (+502)",
        "224"=>"Guinea (+224)",
        "245"=>"Guinea - Bissau (+245)",
        "592"=>"Guyana (+592)",
        "509"=>"Haiti (+509)",
        "504"=>"Honduras (+504)",
        "852"=>"Hong Kong (+852)",
        "36"=>"Hungary (+36)",
        "354"=>"Iceland (+354)",
        "91"=>"India (+91)",
        "62"=>"Indonesia (+62)",
        "98"=>"Iran (+98)",
        "964"=>"Iraq (+964)",
        "972"=>"Israel (+972)",
        "39"=>"Italy (+39)",
        "225"=>"Ivory Coast (+225)",
        "1876"=>"Jamaica (+1876)",
        "81"=>"Japan (+81)",
        "962"=>"Jordan (+962)",
        "7"=>"Kazakhstan (+7)",
        "254"=>"Kenya (+254)",
        "686"=>"Kiribati (+686)",
        "850"=>"Korea North (+850)",
        "82"=>"Korea South (+82)",
        "965"=>"Kuwait (+965)",
        "996"=>"Kyrgyzstan (+996)",
        "856"=>"Laos (+856)",
        "371"=>"Latvia (+371)",
        "961"=>"Lebanon (+961)",
        "266"=>"Lesotho (+266)",
        "231"=>"Liberia (+231)",
        "218"=>"Libya (+218)",
        "417"=>"Liechtenstein (+417)",
        "370"=>"Lithuania (+370)",
        "352"=>"Luxembourg (+352)",
        "853"=>"Macao (+853)",
        "389"=>"Macedonia (+389)",
        "261"=>"Madagascar (+261)",
        "265"=>"Malawi (+265)",
        "60"=>"Malaysia (+60)",
        "960"=>"Maldives (+960)",
        "223"=>"Mali (+223)",
        "356"=>"Malta (+356)",
        "692"=>"Marshall Islands (+692)",
        "596"=>"Martinique (+596)",
        "222"=>"Mauritania (+222)",
        "269"=>"Mayotte (+269)",
        "52"=>"Mexico (+52)",
        "691"=>"Micronesia (+691)",
        "373"=>"Moldova (+373)",
        "377"=>"Monaco (+377)",
        "976"=>"Mongolia (+976)",
        "1664"=>"Montserrat (+1664)",
        "212"=>"Morocco (+212)",
        "258"=>"Mozambique (+258)",
        "95"=>"Myanmar (+95)",
        "264"=>"Namibia (+264)",
        "674"=>"Nauru (+674)",
        "977"=>"Nepal (+977)",
        "31"=>"Netherlands (+31)",
        "687"=>"New Caledonia (+687)",
        "64"=>"New Zealand (+64)",
        "505"=>"Nicaragua (+505)",
        "227"=>"Niger (+227)",
        "234"=>"Nigeria (+234)",
        "683"=>"Niue (+683)",
        "672"=>"Norfolk Islands (+672)",
        "670"=>"Northern Marianas (+670)",
        "47"=>"Norway (+47)",
        "968"=>"Oman (+968)",
        "680"=>"Palau (+680)",
        "507"=>"Panama (+507)",
        "675"=>"Papua New Guinea (+675)",
        "595"=>"Paraguay (+595)",
        "51"=>"Peru (+51)",
        "63"=>"Philippines (+63)",
        "48"=>"Poland (+48)",
        "351"=>"Portugal (+351)",
        "1787"=>"Puerto Rico (+1787)",
        "974"=>"Qatar (+974)",
        "262"=>"Reunion (+262)",
        "40"=>"Romania (+40)",
        "7"=>"Russia (+7)",
        "250"=>"Rwanda (+250)",
        "378"=>"San Marino (+378)",
        "239"=>"Sao Tome &amp; Principe (+239)",
        "966"=>"Saudi Arabia (+966)",
        "221"=>"Senegal (+221)",
        "381"=>"Serbia (+381)",
        "248"=>"Seychelles (+248)",
        "232"=>"Sierra Leone (+232)",
        "65"=>"Singapore (+65)",
        "421"=>"Slovak Republic (+421)",
        "386"=>"Slovenia (+386)",
        "677"=>"Solomon Islands (+677)",
        "252"=>"Somalia (+252)",
        "27"=>"South Africa (+27)",
        "34"=>"Spain (+34)",
        "94"=>"Sri Lanka (+94)",
        "290"=>"St. Helena (+290)",
        "1869"=>"St. Kitts (+1869)",
        "1758"=>"St. Lucia (+1758)",
        "249"=>"Sudan (+249)",
        "597"=>"Suriname (+597)",
        "268"=>"Swaziland (+268)",
        "46"=>"Sweden (+46)",
        "41"=>"Switzerland (+41)",
        "963"=>"Syria (+963)",
        "886"=>"Taiwan (+886)",
        "7"=>"Tajikstan (+7)",
        "66"=>"Thailand (+66)",
        "228"=>"Togo (+228)",
        "676"=>"Tonga (+676)",
        "1868"=>"Trinidad &amp; Tobago (+1868)",
        "216"=>"Tunisia (+216)",
        "90"=>"Turkey (+90)",
        "7"=>"Turkmenistan (+7)",
        "993"=>"Turkmenistan (+993)",
        "1649"=>"Turks &amp; Caicos Islands (+1649)",
        "688"=>"Tuvalu (+688)",
        "256"=>"Uganda (+256)",
        "44"=>"UK (+44)",
        "380"=>"Ukraine (+380)",
        "971"=>"United Arab Emirates (+971)",
        "598"=>"Uruguay (+598)",
        "1"=>"USA (+1)",
        "7"=>"Uzbekistan (+7)",
        "678"=>"Vanuatu (+678)",
        "379"=>"Vatican City (+379)",
        "58"=>"Venezuela (+58)",
        "84"=>"Vietnam (+84)",
        "84"=>"Virgin Islands - British (+1284)",
        "84"=>"Virgin Islands - US (+1340)",
        "681"=>"Wallis &amp; Futuna (+681)",
        "969"=>"Yemen (North)+969)",
        "967"=>"Yemen (South)+967)",
        "381"=>"Yugoslavia (+381)",
        "243"=>"Zaire (+243)",
        "260"=>"Zambia (+260)",
        "263"=>"Zimbabwe (+263)"
    ];
});