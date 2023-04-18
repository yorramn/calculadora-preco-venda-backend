<?php

namespace App\Repositories\Products;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends \App\Repositories\BaseRepository
{
    /**
     * @param array|null $fields
     * @param int|null $perPage
     * @param string|null $orderBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
    {
        $fields['lower'] = $fields['lower'] ?? false;
        $query = Product::query()
            ->when(isset($fields['name']), fn ($query) => Product::search($fields['name']))
            ->when(isset($fields['slug']), fn ($query) => Product::search($fields['slug']))
            ->when(isset($fields['description']), fn ($query) => Product::search($fields['description']))
            ->when(isset($fields['price']), fn ($query) => Product::search($fields['price']))
            ->when(isset($fields['status']), fn ($query) => Product::search($fields['status']))
            ->when(isset($fields['category_id']), fn(Builder $builder)
                => $builder->whereHas('category', fn(Builder $query)
                    => $query->where('category_id', $fields['category_id'])))
            ->orderBy($orderBy ?? 'name', $fields['lower'] ? 'asc' : 'desc');
        if(isset($perPage)) return $query->paginate($perPage);
        return $query->get();
    }

    public function assignCategories(Product $product, array $ids) : array
    {
        return $product->category()->sync($ids);
    }
}
