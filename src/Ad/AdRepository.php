<?php namespace Acme\Ad;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Ad;
use Illuminate\Support\MessageBag;

class AdRepository extends BaseRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * @param Ad $model
     */
    public function __construct(Ad $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getAds()
    {
        $query = $this->model->where('active', 1)->whereHas('photos',function($q) {
            $q->latest()->take(1);
        })->take(2)->get();
        return $query;
    }

}