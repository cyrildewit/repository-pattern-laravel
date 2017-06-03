<?php

namespace App\Repositories;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model.
     * @return string
     */
    abstract protected function getModel();

    /**
     * Set model.
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get all.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if($result) {
            $result->delete();
            return true;
        }

        return false;
    }

    /**
     * Make a new instance of the entity to query on.
     *
     * @param array $with
     */
    public function make(array $with = [])
    {
        return $this->_model->with($with);
    }

    /**
     * Return all results that have a required relationship.
     *
     * @param string $relation
     */
    public function has($relation, array $with = [])
    {
        $entity = $this->make($with);

        return $entity->has($relation)->get();
    }

    /**
     * Find a single entity by key value.
     *
     * @param string $key
     * @param string $value
     * @param array $with
     */
    public function getFirstBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->first();
    }

    /**
     * Find many entities by key value.
     *
     * @param string $key
     * @param string $value
     * @param array $with
     */
    public function getManyBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->get();
    }

    /**
     * Get Results by Page.
     *
     * @param int $page
     * @param int $limit
     * @param array $with
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function getByPage($page = 1, $limit = 10, $with = [])
    {
        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = [];

        $query = $this->make($with);

        $model = $query
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->model->count();
        $result->items = $model->all();

        return $result;
    }
}
