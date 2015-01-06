<?php namespace Acme\Setting;

use Acme\Core\BasePresenter;
use Setting;

class Presenter extends BasePresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\Setting\Setting
     */
    public $resource;

    /**
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        $this->resource =  $model;
    }

    public function convertVipPrice()
    {
        $field = $this->resource->vip_price;

        return $this->convertCurrency($field);
    }

    public function convertOnlinePrice()
    {
        $field = $this->resource->online_price;

        return $this->convertCurrency($field);
    }

    public function convertNormalPrice()
    {
        $field = $this->resource->normal_price;

        return $this->convertCurrency($field);
    }

}
