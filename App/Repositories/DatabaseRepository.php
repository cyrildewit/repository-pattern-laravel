<?php

namespace App\Repositories;

use Illuminate\Database\Connection;

abstract class DatabaseRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $_db;

    /**
     * Table where we query on.
     *
     * @var string $_table
     */
    protected $_table;

    /**
     * EloquentRepository constructor.
     */
    public function __construct(Connection $db)
    {
        $this->_db = $db;
        $this->setTable();
    }

    /**
     * Get model.
     * @return string
     */
    abstract protected function getTable();

    /**
     * Set model.
     */
    public function setTable()
    {
        $this->_table = $this->getTable();
    }

    public function table()
    {
        return $this->_db->table($this->_table);
    }

    /**
     * Get all.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->table()->get();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->table()->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->table()->insert($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->table()->where('id', $id);

        if ($result) {
            $result->update($attributes);

            return $result->first();
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

        if ($result) {
            $result->delete();
            return true;
        }

        return false;
    }

    /**
     * Find a single entity by key value.
     *
     * @param string $key
     * @param string $value
     */
    public function getFirstBy($key, $value)
    {
        return $this->table()->where($key, '=', $value)->first();
    }

    /**
     * Find many entities by key value.
     *
     * @param string $key
     * @param string $value
     */
    public function getManyBy($key, $value)
    {
        return $this->table()->where($key, '=', $value)->get();
    }

    /**
     * Get Results by Page.
     *
     * @param int $page
     * @param int $limit
     * @param array $with
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function getByPage($page = 1, $limit = 10)
    {
        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = [];

        $query = $this->table();

        $model = $query
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->table()->count();
        $result->items = $model->all();

        return $result;
    }
}
