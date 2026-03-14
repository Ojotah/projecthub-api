<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;
use RuntimeException;

class BaseService
{
    /**
     * Every service must define its model.
     */
    public function getModel(): Model
    {
        throw new RuntimeException('Model not implemented in service.');
    }

    /**
     * Base query builder for the model.
     *
     * TODO:
     * In the future we can extend this method to support:
     * - API filtering
     * - search
     * - multi-tenant scopes
     * - global query constraints
     */
    public function getQuery(?array $filters = []): Builder
    {
        return $this->getModel()->query();
    }

    public function all(array $with = []): Collection
    {
        return $this->getQuery()->with($with)->get();
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->getQuery()->with($with)->paginate($perPage);
    }

    public function find(int $id, array $with = []): Model
    {
        return $this->getQuery()
            ->with($with)
            ->findOrFail($id);
    }

    public function findBy(string $key, mixed $value, array $with = []): Collection
    {
        return $this->getQuery()
            ->when(
                is_array($value),
                fn (Builder $builder) => $builder->whereIn($key, Arr::wrap($value)),
                fn (Builder $builder) => $builder->where($key, $value)
            )
            ->with($with)
            ->get();
    }

    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->find($id);

        $model->update($data);

        return $model;
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    public function dropdown(): SupportCollection
    {
        return $this->getQuery()->pluck('name', 'id');
    }
}
