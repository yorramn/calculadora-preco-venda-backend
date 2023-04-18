<?php

namespace App\Repositories\Category;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

class CategoryRepository extends \App\Repositories\BaseRepository
{
    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator | Collection
    {
        $query = Category::query()
            ->when(count($fields) > 0, fn($query) =>
                $query->when(isset($fields['name']), fn(Builder $builder) => $builder->where('name', 'like', '%'.$fields['name'].'%'))
                    ->when(isset($fields['slug']), fn(Builder $builder) => $builder->where('slug', 'like', '%'.$fields['slug'].'%')))
            ->orderBy($orderBy ?? 'name');
        if(isset($perPage)) return $query->paginate($perPage);
        return $query->get();
    }
}
