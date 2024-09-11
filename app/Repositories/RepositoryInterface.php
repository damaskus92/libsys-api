<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Retrieve all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all();

    /**
     * Find a record by its primary key.
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id);

    /**
     * Create a new record.
     *
     * @param  array|mixed  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update a record by its primary key.
     *
     * @param  int|mixed  $id
     * @param  array|mixed  $data
     * @return bool|null
     */
    public function update($id, array $data);

    /**
     * Delete a record by its primary key.
     *
     * @param  int|mixed  $id
     * @return bool|null
     */
    public function delete($id);
}
