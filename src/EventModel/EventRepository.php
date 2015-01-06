<?php namespace Acme\EventModel;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Carbon\Carbon;
use DB;
use EventModel;

class EventRepository extends BaseRepository {

    use CrudableTrait;

    public $model;

    public function __construct(EventModel $model)
    {
        $this->model = $model;
    }

    public function getAll($with = [])
    {
        return $this->model->with($with)->latest();
    }

    /**
     * Return Events For Event Index Page
     * @param $perPage
     * @return mixed
     *
     */
    public function getNonExpiredEvents($perPage = 10)
    {
        return $this->getAll()
            ->where('date_start', '>', Carbon::now()->subDay())
//            ->orWhere('date_end', '<', Carbon::now()->subDay())
            ->orderBy('date_start', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->paginate($perPage);
    }

    /**
     * Return Events For Event Index Page
     * @param $perPage
     * @return mixed
     *
     */
    public function getPastEvents($perPage = 10)
    {
        return $this->getAll()
            ->where('date_start', '<', Carbon::now())
            ->orderBy('date_start', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->paginate($perPage);
    }

    /**
     * @return array|null|static[]
     * Fetch Posts For Sliders
     */
    public function getSliderEvents()
    {
        // fetch 3 latest post
        // fetches 2 featured post
        // order by event date, date created, featured
        // combines them into one query to return for slider
        $latestEvents   = $this->latestEvents();
        $featuredEvents = $this->feautredEvents();
        $events         = array_merge((array) $latestEvents, (array) $featuredEvents);
        if ( $events ) {
            foreach ( $events as $event ) {
                $array[] = $event->id;
            }
            $events_unique = array_unique($array);
            $sliderEvents  = $this->mergeSliderEvents(6, $events_unique);

            return $sliderEvents;
        } else {
            return null;
        }

    }

    /**
     * Fetches posts for latest Event
     * @return array
     *
     */
    public function latestEvents()
    {
        return DB::table('events as e')
            ->join('photos as p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '>', Carbon::now()->toDateTimeString())
            ->orderBy('e.date_start', 'ASC')
            ->orderBy('e.created_at', 'DESC')
            ->take('5')
            ->get(array('e.id'));
    }

    /**
     * Fetches posts for latest Event
     * @return array
     *
     */
    public function feautredEvents()
    {
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '>', Carbon::now()->toDateTimeString())
            ->where('e.featured', '1')
            ->orderBy('e.date_start', 'ASC')
            ->orderBy('e.created_at', 'DESC')
            ->take('5')
            ->get(array('e.id'));
    }

    /**
     * @param $limit
     * @param $array
     * @return array|static[]
     * Merge Slider Events
     */
    public function mergeSliderEvents($limit, $array)
    {
        $events = DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->whereIn('e.id', $array)
            ->take($limit)
            ->groupBy('e.id')
            ->get(array('e.id', 'e.title_ar', 'e.title_en', 'e.description_ar', 'e.description_en', 'p.name', 'e.button_ar', 'e.button_en'));

        return $events;
    }

    /**
     * @param $dateStart
     * @return bool
     * check if the event expired
     */
    public function eventExpired($dateStart)
    {
        $expired = false;
        $now     = Carbon::now();
        if ( $now > $dateStart ) {
            $expired = true;
        }

        return $expired;
    }

    /**
     * @param $startDate DateTimeString
     * @param $endDate DateTimeString
     * @return bool
     * Check whether the user can subscribe to this event or watch online
     *
     */
    public function ongoingEvent($startDate, $endDate)
    {
        $startAt = $startDate->subHours(5);
        $endAt   = $endDate->addHours(5);
//
        $now     = Carbon::now();
        $ongoing = false;

        if ( ($now > $startAt) && ($now < $endAt) ) {
//            // If Current Time is close to 5 hours from start date AND current time is 5 hours is less than end date
//            // This sets the the ongoing to true If the
//            // todo: if the event is 3 days, then $now will not be > $startAt
            $ongoing = true;
        }

        return $ongoing;
    }

    public function getExpiredEvents()
    {
        return $this->where('date_start', '<', Carbon::now())->get();
    }

}