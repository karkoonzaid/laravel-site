<?php namespace Acme\Category;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Category;
use Illuminate\Support\MessageBag;

class CategoryRepository extends BaseRepository {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getEventCategories()
    {
        return $this->model->where('type', '=', 'EventModel');
    }

    public function getPostCategories()
    {
        return $this->model->where('type', '=', 'Post');
    }

    public function type()
    {
        return $this->type();
    }

}