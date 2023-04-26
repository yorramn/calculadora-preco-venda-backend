<?php

namespace App\Http\Controllers\Api\Plan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\StorePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Http\Resources\Plan\PlanResource;
use App\Models\Plan\Plan;
use App\Services\PlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class PlanController extends Controller
{
    private PlanService $planService;

    /**
     * @param PlanService $planService
     */
    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $fields = $request->only([
            'name',
            'slug',
            'per_page',
            'order_by'
        ]);
        $response = $this->planService->findAll($fields, null, 'price');

        if($response->count() <= 0){
            return new JsonResponse([
                'status' => Http::NO_CONTENT(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::NO_CONTENT());
        }


        return new JsonResponse([
            'status' => Http::OK(),
            'data' => PlanResource::collection($response),
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
