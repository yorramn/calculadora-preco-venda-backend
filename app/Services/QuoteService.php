<?php

namespace App\Services;

use App\Enums\Product\ProductStatusEnum;
use App\Models\Quote\Quote;
use App\Repositories\Quotes\QuoteRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuoteService implements BaseServiceApi
{
    private QuoteRepository $quoteRepository;
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->quoteRepository = new QuoteRepository(new Quote());
        $this->productService = $productService;
    }

    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
    {
        return Quote::query()
            ->whereRelation('owner', 'user_id', '=', \auth()->user()->id)
            ->get();
    }

    public function store(array $data) : Model
    {
        return $this->quoteRepository->create($data);
    }

    public function createMany(array $data) : Collection | array {
        $data = Arr::map($data, function ($quote) {
            $quote['user_id'] = Auth::user()->id;
            $quote['product_id'] = $this->productService->store(data: [
                'name' => $quote['name'],
                'slug' => $quote['name'],
                'description' => $quote['name'],
                'price' => $quote['price_sale'],
                'user_id' => $quote['user_id'],
            ])->id;
            return $quote;
        });
        return $this->quoteRepository
            ->createMany($data);
    }

    public function show(int $id): Model|null
    {
        return $this->quoteRepository->findById($id);
    }

    public function update(int $id, array $data): bool|int|Model
    {
        $quote = $this->quoteRepository->findById($id);
        return $quote->update($data);
    }

    public function delete(int $id): bool|int
    {
        // TODO: Implement delete() method.
    }
}
