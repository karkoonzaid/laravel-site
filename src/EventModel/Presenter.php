<?php namespace Acme\EventModel;

use Acme\Core\BasePresenter;
use EventModel;
use User;

class Presenter extends BasePresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\EventModel\EventModel|\User $model
     */
    public $resource;

    public function __construct(EventModel $model)
    {
        $this->resource = $model;
    }

    public function date_start()
    {
        return $this->resource->date_start->format('Y-m-d H:i');
    }

    public function date_end()
    {
        return $this->resource->date_end->format('Y-m-d H:i');
    }

    public function convertPrice()
    {
        $field = $this->resource->price;

        return $this->convertCurrency($field);
    }

    public function convert($price)
    {
        return $this->convertCurrency($price);
    }

}
