<?php namespace Acme\EventPrice;

use Acme\Core\BaseRepository;
use EventPrice;
use Illuminate\Support\MessageBag;

class EventPriceRepository extends BaseRepository{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public function __construct(EventPrice $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function findByType($eventId,$countryId,$type)
    {
        return $this->model->where('event_id',$eventId)->where('country_id',$countryId)->where('type',$type)->first();
    }
}