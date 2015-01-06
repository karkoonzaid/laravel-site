<?php namespace Acme\Subscription;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use DB;
use Subscription;

class SubscriptionRepository extends BaseRepository {

    use CrudableTrait;

    public $model;

//    public $subscriptionStatuses = ['REJECTED', 'PENDING', 'APPROVED', 'CONFIRMED', 'PAYMENT','CANCELLED'];
    public $subscriptionStatuses = ['REJECTED', 'APPROVED','CONFIRMED'];

    public function __construct(Subscription $model)
    {
        $this->model = $model;
    }

    public function registrationType()
    {
        return $this->registrationType;
    }

    public function findByEvent($userId, $eventId)
    {
        $record = $this->model->where('user_id', $userId)->where('event_id', $eventId)->first();
        if ( ! $record ) return false;

        return $record;
    }


    public function getAll($with = [])
    {
        return $this->model->with($with)->latest()->paginate(200);
    }

    /**
     * @param $eventId
     * @internal param $subscribableId
     * @return mixed
     * Count no of subscriptions for an Event
     */
    public function countAll($eventId)
    {
        return $this->model->where('event_id', $eventId)
            ->get([
                DB::raw('COUNT(id) as subscription_count')
            ]);
    }

    public function findAllSubscriptionsForUser($userId)
    {
        $records = $this->model->where('user_id', $userId)->get();

        return $records;
    }

    public function findAllPackageSubscriptionsForUser($userId, array $eventId)
    {
        $records = $this->model->where('user_id', $userId)->whereIn('event_id', $eventId)->get();

        return $records;
    }



    /**
     * @param $id eventId
     * @param $userId int
     * @return boolean
     * Is User subsribed to this event
     */
    public function isSubscribed($id, $userId)
    {
        $query = $this->model->where('user_id', '=', $userId)->where('event_id', '=', $id)->count();

        return ($query >= 1) ? true : false;
    }

}