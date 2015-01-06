<?php
use Acme\Category\CategoryRepository;
use Acme\EventModel\EventRepository;
use Acme\Location\LocationRepository;
use Acme\Package\PackageRepository;
use Acme\Photo\PhotoRepository;
use Acme\Setting\SettingRepository;
use Acme\Tag\TagRepository;
use Acme\User\UserRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class AdminEventsController extends AdminBaseController {

    protected $eventRepository;
    protected $user;
    protected $category;
    protected $photo;
    protected $photoRepository;
    protected $locationRepository;
    protected $eventTags;
    /**
     * @var Acme\Setting\SettingRepository
     */
    private $settingRepository;
    /**
     * @var Acme\EventModel\EventPhotoService
     */
    private $imageService;
    /**
     * @var Acme\Package\PackageRepository
     */
    private $packageRepository;
    /**
     * @var Acme\Tag\TagRepository
     */
    private $tagRepository;

    function __construct(EventRepository $eventRepository, CategoryRepository $categoryRepository, LocationRepository $locationRepository, UserRepository $userRepository, PhotoRepository $photoRepository, SettingRepository $settingRepository, PackageRepository $packageRepository, eventModel $eventTags, TagRepository $tagRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository     = $userRepository;
        $this->photoRepository    = $photoRepository;
        $this->locationRepository = $locationRepository;
        $this->settingRepository  = $settingRepository;
        $this->packageRepository  = $packageRepository;
        $this->eventTags          = $eventTags;
        $this->tagRepository      = $tagRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $events   = $this->eventRepository->getAll(array('category', 'location.country', 'setting'))->paginate(10);
        $packages = $this->packageRepository->getAll();
        $this->render('admin.events.index', compact('events', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = $this->select + $this->categoryRepository->getEventCategories()->lists('name_ar', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $location = $this->select + $this->locationRepository->getAll()->lists('name_ar', 'id');
        $tags     = [''=>''] + $this->tagRepository->getList('name_ar','id');
        $this->render('admin.events.create', compact('category', 'author', 'location', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $val = $this->eventRepository->getCreateForm();

        if ( !$val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( Input::get('date_start') > Input::get('date_end') ) {
            return Redirect::back()->with('error', 'Date Start must be lesser than date end')->withInput();
        }

        if ( !$event = $this->eventRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        if ( !$setting = $this->settingRepository->create(['settingable_type' => 'EventModel', 'settingable_id' => $event->id]) ) {
            $this->eventRepository->delete($event);

            //@todo redirect
            return Redirect::back()->with('errors', 'could not create event');
        }

        // update the tags
        $tags = is_array(Input::get('tags')) ? array_filter(Input::get('tags')) : [];
        $this->tagRepository->attachTags($event, $tags);

        // Create a settings record for the inserted event
        // Settings Record needs to know Which type of Record and The Foreign Key it needs to Create
        // So pass these fields with Session (settableType,settableId)

        return Redirect::action('AdminSettingsController@edit',[$setting->id,'store'=>'true']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $event      = $this->eventRepository->findById($id, ['photos']);
        $tags       = $this->tagRepository->getList('name_ar','id');
        $dbTags =     $event->tags->lists('id');

        $category = $this->select + $this->categoryRepository->getEventCategories()->lists('name_ar', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $location = $this->select + $this->locationRepository->getAll()->lists('name_ar', 'id');

        $this->render('admin.events.edit', compact('event', 'category', 'author', 'location', 'dbTags', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $event = $this->eventRepository->findById($id);

        $val = $this->eventRepository->getEditForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( Input::get('date_start') > Input::get('date_end') ) {
            return Redirect::back()->with('error', 'Event Date Start Cannot be greater than Event End Date');
        }

        if ( !$this->eventRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        // update the tags
        $tags = is_array(Input::get('tags')) ? array_filter(Input::get('tags')) : [];
        $this->tagRepository->attachTags($event, $tags);

        return Redirect::action('AdminEventsController@index')->with('success', 'Updated');
//        return Redirect::action('AdminEventsController@edit',$event->id)->with('success', 'Updated');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ( $this->eventRepository->findById($id)->delete() ) {
            //  return Redirect::home();
            return Redirect::action('AdminEventsController@index')->with('success', 'Event Deleted');
        }

        return Redirect::action('AdminEventsController@index')->with('error', 'Error: Event Not Found');
    }

    /**
     * @param $id
     * @return statement
     * Send Notification Email for the Event Followers
     */
    public function getMailFollowers($id)
    {
        $event = $this->eventRepository->findById($id);
        $this->render('admin.events.mail-followers', compact('event'));
    }

    public function postMailFollowers($id)
    {
        $event     = $this->eventRepository->findById($id);
        $followers = $event->followers;
        if ( count($followers) >= 1 ) {
            $array = array_merge(['subscribers' => $followers->toArray()], Input::all());
            try {
                Event::fire('events.mail-subscribers', [$array]);
            }
            catch ( \Exception $e ) {
                return Redirect::back()->with('error', 'Email Could not send');
            }
        }

        return Redirect::action('AdminEventsController@getFollowers', $event->id)->with('success', 'Email Sent');
    }

    public function getMailFavorites($id)
    {
        $event = $this->eventRepository->findById($id);
        $this->render('admin.events.mail-favorites', compact('event'));
    }

    public function postMailFavorites($id)
    {
        $event     = $this->eventRepository->findById($id);
        $favorites = $event->favorites;

        if ( count($favorites) >= 1 ) {
            $array = array_merge(['subscribers' => $favorites->toArray()], Input::all());

            try {
                Event::fire('events.mail-subscribers', [$array]);
            }

            catch ( \Exception $e ) {
                return Redirect::back()->with('error', 'Email Could not send');
            }
        }

        return Redirect::action('AdminEventsController@getFavorites', $event->id)->with('success', 'Email Sent');
    }


    public function getMailSubscribers($id)
    {
        $event = $this->eventRepository->findById($id);
        $this->render('admin.events.mail-subscribers', compact('event'));
    }

    public function postMailSubscribers($id)
    {
        $status = Input::get('status');

        $event = $this->eventRepository->findById($id);

        if ( isset($status) && !(empty($status)) ) {
            $subscribers = $event->subscribers()->ofStatus(strtoupper($status))->get()->toArray();
        } else {
            $subscribers = $event->subscribers->toArray();
        }
        if ( count($subscribers) >= 1 ) {
            $array = array_merge(['subscribers' => $subscribers], Input::all());

            try {
                Event::fire('events.mail-subscribers', [$array]);
            }

            catch ( \Exception $e ) {
                return Redirect::back()->with('error', 'Email Could not send');
            }

        }

        return Redirect::action('AdminEventsController@getSubscriptions', $event->id)->with('success', 'Email Sent');
    }

    public function getSettings($id)
    {
        $event               = $this->eventRepository->findById($id);
        $subscriptions_count = $event->subscriptions()->where('status', 'CONFIRMED')->count();
        $favorites_count     = $event->favorites()->count();
        $followers_count     = $event->followers()->count();
        $requests_count      = $event->subscriptions()->count();

        $this->render('admin.events.settings', compact('event', 'subscriptions_count', 'favorites_count', 'followers_count', 'requests_count'));
    }

    public function getDetails($id)
    {
        $event               = $this->eventRepository->findById($id);
        $subscriptions_count = $event->subscriptions()->count();
        $favorites_count     = $event->favorites()->count();
        $followers_count     = $event->followers()->count();
        $requests_count      = $event->requests()->count();

        $event->updateAvailableSeats();

        $this->render('admin.events.details', compact('event', 'subscriptions_count', 'favorites_count', 'followers_count', 'requests_count'));
    }


    /**
     * @param $id
     * @return mixed
     * Returns the Followers For the Post, Event
     */
    public function getFollowers($id)
    {
        $users = $this->eventRepository->findById($id)->followers;
        $event = $this->eventRepository->findById($id);

        $this->render('admin.events.followers', compact('users', 'event'));
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Favorites For the Post, Event
     */
    public function getFavorites($id)
    {
        $users = $this->eventRepository->findById($id)->favorites;
        $event = $this->eventRepository->findById($id);

        $this->render('admin.events.favorites', compact('users', 'event'));
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Subscriptions For the Post, Event
     */
    public function getSubscriptions($id)
    {

        $status = Input::get('status');
        $type   = Input::get('type');

        if ( !isset($type) ) {
            $type = 'event';
        }
        $event = $this->eventRepository->findById($id);

        if ( isset($status) ) {
            $subscriptions = $event->subscriptions()->ofStatus(strtoupper($status))->get();
        } else {
            $subscriptions = $event->subscriptions;
        }

        $this->render('admin.events.subscriptions', compact('event', 'subscriptions', 'type'));

    }

    public function getRequests($id)
    {
        $event = $this->eventRepository->findById($id,['requests.user']);
        $this->render('admin.events.requests', compact('event'));
    }


    public function selectType()
    {
        $this->render('admin.events.select-type');
    }


}
