<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data) : Model
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    /**
     * @param array $validation
     * @param array $data
     * @return Model
     */
    public function updateOrCreate(array $validation, array $data) : Model
    {
        return $this->model
            ->newQuery()
            ->updateOrCreate($validation,$data);
    }

    /**
     * @param int $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function findById(int $id) : Model
    {
        return $this->model
            ->newQuery()
            ->find($id);
    }

    /**
     * @param array|null $fields
     * @param int|null $perPage
     * @param string|null $orderBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator | Collection
    {
        return $this->model
            ->newQuery()
            ->when(isset($orderBy), function (Builder $query) use ($orderBy){
                return $query->orderBy($orderBy);
            })
            ->paginate($perPage ?? 10);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool|int
     */
    public function updateById(int $id, array $data) : bool
    {
        return $this->model
            ->newQuery()
            ->find($id)
            ->update($data);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function updateByModel(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public function deleteById(int $id)
    {
        return $this->model
            ->newQuery()
            ->find($id)
            ->delete();
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function deleteByModel(Model $model): bool
    {
        return $model->delete();
    }
}
