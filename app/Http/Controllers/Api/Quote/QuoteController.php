<?php

namespace App\Http\Controllers\Api\Quote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\ChangeStatusQuoteRequest;
use App\Http\Resources\Quote\QuoteResource;
use App\Models\Quote\Quote;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class QuoteController extends Controller
{
    private QuoteService $quoteService;

    /**
     * @param QuoteService $quoteService
     */
    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->only([
            'name',
            'total_fixed_cost',
            'total_variable_cost',
            'total',
            'price',
            'link',
            'status',
            'category_id',
            'product_id',
            'user_id'
        ]);
        $others = $request->only(['per_page', 'order_by']);
        $response = $this->quoteService->findAll($fields, $others['per_page'] ?? null, $others['order_by'] ?? null);
        if($response->count() <= 0){
            return new JsonResponse([
                'status' => Http::NO_CONTENT(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::NO_CONTENT());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => QuoteResource::collection($response),
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\Quote\StoreQuoteRequest $storequoteRequest)
    {
        $quotes = $this->quoteService->createMany($storequoteRequest->validated());
        if($quotes->isEmpty())
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Produto não criado.'
            ], Http::BAD_REQUEST());

        return new JsonResponse([
            'status' => Http::CREATED(),
            'data' => QuoteResource::collection($quotes),
            'message' => 'Dados encontrados.'
        ], Http::CREATED());
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }

    public function change_status(int $id, ChangeStatusQuoteRequest $changeStatusQuoteRequest) : JsonResponse
    {
        $quote = $this->quoteService->show($id);
        if(!$quote->exists)
            return new JsonResponse([
                'status' => Http::NOT_FOUND(),
                'data' => null,
                'message' => 'Orçamento não encontrado.'
            ], Http::NOT_FOUND());

        if(!$this->quoteService->update($id, $changeStatusQuoteRequest->validated()))
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Orçamento não atualizado.'
            ], Http::BAD_REQUEST());

        return new JsonResponse([
            'status' => Http::OK(),
            'data' => QuoteResource::collection($this->quoteService->findAll(null, null)),
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }
}
