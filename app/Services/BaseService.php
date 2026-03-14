<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected Model $model;

    public function all(array $relations = [])
    {
        return $this->model->with($relations)->paginate();
    }

    public function find(int $id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id)
    {
        $record = $this->find($id);

        return $record->delete();
    }
}
