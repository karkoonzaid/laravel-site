<?php namespace Acme\User;

use Acme\Core\BasePresenter;
use User;

class Presenter extends BasePresenter {

    public function __construct(User $model) {
        $this->resource = $model;
    }

}
