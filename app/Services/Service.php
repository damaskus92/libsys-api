<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;

class Service
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Find a record by its primary key.
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Create a new record.
     *
     * @param  array|mixed  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
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
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a record by its primary key.
     *
     * @param  int|\Illuminate\Database\Eloquent\Model  $id
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
