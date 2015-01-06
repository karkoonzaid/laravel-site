<?php namespace Acme\Refund;

use Acme\Core\BaseRepository;
use Refund;

class RefundRepository extends BaseRepository {

    /**
     * @param Refund $model
     */
    public function __construct(Refund $model)
    {
        $this->model = $model;
    }

}