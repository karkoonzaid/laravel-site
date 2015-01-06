<?php namespace Acme\Blog;

use Acme\Core\BasePresenter;
use Blog;

class Presenter extends BasePresenter {

    public function __construct(Blog $model) {
        $this->resource = $model;
    }

}
