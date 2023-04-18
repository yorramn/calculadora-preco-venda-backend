<?php

namespace App\Services;

use App\Models\Product\Product;
use App\Repositories\Products\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductService implements BaseServiceApi
{
    private ProductRepository  $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository(new Product());
    }

    /**
     * @param array|null $fields
     * @param int|null $perPage
     * @param string|null $orderBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
    {
        return $this->productRepository->findAll($fields, $perPage, $orderBy);
    }

    public function store(array $data): Model
    {
        $data['user_id'] = auth()->user()->id ?? 1;
        return $this->productRepository->create($data);
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

    public function assignCategories(Product|Model $product, array $ids) : array
    {
        return $this->productRepository->assignCategories(product: $product, ids: $ids);
    }
}
