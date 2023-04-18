<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class ProductController extends Controller
{
    private ProductService $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $fields = $request->only([
            'name',
            'slug',
            'description',
            'price',
            'status',
            'lower',
            'user_id',
            'category_id',
        ]);
        $others = $request->only(['per_page', 'order_by']);
        $response = $this->productService->findAll($fields, $others['per_page'] ?? null, $others['order_by'] ?? null);
        if($response->count() <= 0){
            return new JsonResponse([
                'status' => Http::NO_CONTENT(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::NO_CONTENT());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => $response,
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->store($request->validated());
        $response = $this->productService->assignCategories($product, $request->validated('categories'));
        if(!$product->exists)
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Produto não criado.'
            ], Http::BAD_REQUEST());

        if(count($response) <= 0)
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Não foi possível atribuir categoria a este produto.'
            ], Http::BAD_REQUEST());

        return new JsonResponse([
            'status' => Http::CREATED(),
            'data' => new ProductResource($product),
            'message' => 'Dados encontrados.'
        ], Http::CREATED());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        //
    }
}
