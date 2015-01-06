<?php namespace Acme\Core;

use Acme\Core\Exceptions\EntityNotFoundException;
use Illuminate\Database\Eloquent\Model;
use StdClass;
use Illuminate\Support\MessageBag;
use Symfony\Component\Process\Exception\InvalidArgumentException;

abstract class BaseRepository {

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Construct
     *
     * @param \Illuminate\Support\MessageBag $errors
     */
    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param array $attributes
     * @return Model|static
     * Get new instance of the Model
     */
    public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * @return Model
     * get the current model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $model
     * Set the model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param array $with
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * wrapper for eloquent all();
     */
    public function getAll($with = [])
    {
        if ( isset($with) && (! empty($with)) ) {
            if ( ! is_array($with) ) throw new InvalidArgumentException;


            return $this->model->with($with)->get();
        }

        return $this->model->all();
    }

    public function getAllPaginated($with = [], $perPage = 10)
    {
        if ( isset($with) && (! empty($with)) ) {
            if ( ! is_array($with) ) throw new InvalidArgumentException;

            return $this->model->with($with)->latest()->paginate($perPage);

        }

        return $this->model->paginate($perPage);
    }

    /**
     * @param $id
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static
     */
    public function getById($id, array $with = [])
    {
        if ( isset($with) && (! empty($with)) ) {
            if ( ! is_array($with) ) throw new InvalidArgumentException;

            return $this->model->with($with)->find($id);
        }

        return $this->model->find($id);
    }

    /**
     * @param $id
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static
     * @throws EntityNotFoundException
     */
    public function findById($id, array $with = [])
    {

        if ( isset($with) && (! empty($with)) ) {
            if ( ! is_array($with) ) throw new InvalidArgumentException;

            $model = $this->model->with($with)->find($id);
        } else {

            $model = $this->model->find($id);
        }

        return $model;
    }

    public function getFirst()
    {
        return $this->model->first();
    }

    public function getFirstOrFail()
    {
        return $this->model->firstOrFail();
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function make(array $with = array())
    {
        return $this->model->with($with);
    }

    /**
     * Get Results by Page
     *
     * @param int $page
     * @param int $limit
     * @param array $with
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function getByPage($page = 1, $limit = 10, $with = array())
    {
        $result             = new StdClass;
        $result->page       = $page;
        $result->limit      = $limit;
        $result->totalItems = 0;
        $result->items      = array();

        $query = $this->make($with);

        $users = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->model->count();
        $result->items      = $users->all();

        return $result;
    }

    /**
     * Search for many results by key and value
     *
     * @param string $key
     * @param mixed $value
     * @param array $with
     * @return \Illuminate\Database\Query\Builders
     */
    public function getBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->get();
    }

    /**
     * Return the errors
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Set error message bag
     *
     * @var \Illuminate\Support\MessageBag
     * @return \Illuminate\Support\MessageBag
     */
    public function addError($errorMsg)
    {
        //@todo enhance snake_case to remove spaces
        $key = snake_case($errorMsg);

        return $this->errors->add($key, $errorMsg);
    }

    /**
     * @param $model
     * @return mixed
     */
    protected function storeEloquentModel($model)
    {
        if ( $model->getDirty() ) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function storeArray($data)
    {
        $model = $this->getNew($data);

        return $this->storeEloquentModel($model);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function save(Model $model)
    {
        if ( $model->getDirty() ) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    /**
     * @return namespaced class path
     * Initiatialize the class path for validation
     */
    public function initValidatorClass()
    {
        $calledClass = new \ReflectionClass($this);
        $baseClass   = $this->filterClassName($calledClass->getShortName());
        $fullPath    = 'Acme\\' . $baseClass . '\\Validators\\';
        return $fullPath;
    }

    /**
     * Remove Repository Word From the param
     */
    public function filterClassName($className)
    {
        $finalClassName = str_replace('Repository', '', $className);

        // because if Repository stripped out from EventRepository only Event will be returned.
        if ($finalClassName == 'Event') return 'EventModel';

        return $finalClassName;
    }

    public function getList($column)
    {
        return $this->model->lists($column, 'id');
    }

    public function getAllByStatus($status, $array)
    {
        return $this->model->ofStatus($status)->with($array)->latest()->paginate(200);
    }
}
