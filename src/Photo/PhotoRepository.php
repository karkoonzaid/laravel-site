<?php namespace Acme\Photo;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Illuminate\Support\MessageBag;
use Photo;

class PhotoRepository extends BaseRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Illuminate\Database\Eloquent\Model|\Photo $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Photo $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}