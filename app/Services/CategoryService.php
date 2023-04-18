<?php

namespace App\Services;

use App\Models\Category\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository(new Category());
    }

    /**
     * @param array|null $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function findAll(?array $data): \Illuminate\Contracts\Pagination\LengthAwarePaginator | Collection
    {
        return $this->categoryRepository->findAll($data ?? null, $data['per_page'] ?? null, $data['order_by'] ?? 'name');
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data): \Illuminate\Database\Eloquent\Model
    {
        $data['user_id'] = Auth::user()->id;
        return $this->categoryRepository->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool|int
     */
    public function update(int $id, array $data): bool|int
    {
        return $this->categoryRepository->updateById($id, $data);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
     */
    public function show(int $id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->categoryRepository->findById($id);
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public function delete(int $id): bool|int
    {
        return $this->categoryRepository->deleteById($id);
    }
}
