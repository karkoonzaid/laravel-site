<?php namespace Acme\Location;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Illuminate\Support\MessageBag;
use Location;

class LocationRepository extends BaseRepository {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Illuminate\Database\Eloquent\Model|\Location $model
     */
    public function __construct(Location $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}