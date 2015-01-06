<?php namespace Acme\Comment;

use Acme\Core\BasePresenter;
use Comment;

class Presenter extends BasePresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\EventModel\EventModel|\User $model
     */
    public  $resource;

    public function __construct(Comment $model) {
        $this->resource = $model;
    }

}
