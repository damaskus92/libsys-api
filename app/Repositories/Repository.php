<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a record by its primary key.
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record.
     *
     * @param  array|mixed  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record by its primary key.
     *
     * @param  int|mixed  $id
     * @param  array|mixed  $data
     * @return bool|null
     */
    public function update($id, array $data)
    {
        $record = $this->find($id);

        return $record ? $record->update($data) : null;
    }

    /**
     * Delete a record by its primary key.
     *
     * @param  int|mixed  $id
     * @return bool|null
     */
    public function delete($id)
    {
        $record = $this->find($id);

        return $record ? $record->delete() : null;
    }
}
