<?php

namespace App\Services;

use App\Models\Plan\Plan;
use App\Repositories\Plans\PlanRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PlanService implements BaseServiceApi
{
    private PlanRepository $planRepository;


    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function findById(int $id) : Model {
        return Plan::query()->find($id);
    }

    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
    {
        return Plan::query()->orderBy('price')->get();
    }

    public function store(array $data): Model
    {
        // TODO: Implement store() method.
    }

    public function show(int $id): Model|null
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data): bool|int|Model
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): bool|int
    {
        // TODO: Implement delete() method.
    }

    public function assignPlanToUser(array $data)  {
        return $this->planRepository->assignPlanToUser($data);
    }
}
