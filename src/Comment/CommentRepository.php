<?php namespace Acme\Comment;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Comment;
use Illuminate\Support\MessageBag;

class CommentRepository extends BaseRepository  {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getEventCategories() {
        return $this->model->where('type','=', 'EventModel');
    }
    public function getPostCategories() {
        return $this->model->where('type','=', 'Post');
    }

    public function type() {
        return $this->type();
    }

}