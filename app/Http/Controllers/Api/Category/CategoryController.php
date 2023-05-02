<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     *@OA\Get(
     *  path="/api/categories",
     *  summary="Retorna a lista de categorias",
     *  description="Este endpoint retornará a lista completa de categorias",
     *  @OA\Response(
     *     response="200",
     *     description="Retorna JSON com status 200"
     * ),
     *)
     * @OA\Info(
     *   title="Categorias",
     *   contact="yorramn.dev@gmail.com",
     *   version="1.0.0"
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $fields = $request->only([
            'name',
            'slug',
            'per_page',
            'order_by'
        ]);
        $response = $this->categoryService->findAll($fields);
        if($response->count() <= 0){
            return new JsonResponse([
                'status' => Http::NO_CONTENT(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::NO_CONTENT());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => CategoryResource::collection($response),
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @return JsonResponse
     */
    public function store(CategoryRequest $categoryRequest): JsonResponse
    {
        $response = $this->categoryService->store($categoryRequest->validated());
        if(!$response){
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::BAD_REQUEST());
        }
        return new JsonResponse([
            'status' => Http::CREATED(),
            'data' => CategoryResource::collection($this->categoryService->findAll(null)),
            'message' => 'Dados encontrados.'
        ], Http::CREATED());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $response = $this->categoryService->show($id);
        if(!$response){
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::BAD_REQUEST());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => new CategoryResource($response),
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @param int $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $categoryRequest, int $id): JsonResponse
    {
        $response = $this->categoryService->update($id, $categoryRequest->validated());
        if(!$response){
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::BAD_REQUEST());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => new CategoryResource($this->categoryService->show($id)),
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $response = $this->categoryService->delete($id);
        if(!$response){
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::BAD_REQUEST());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => null,
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }
}
