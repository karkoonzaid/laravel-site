<?php namespace Acme\Package;

use Acme\Core\BaseRepository;
use Acme\Core\CrudableTrait;
use Package;

class PackageRepository extends BaseRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Package $model)
    {
        $this->model = $model;
    }

}