<?php

namespace App\Http\Controllers\Api\Plan;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignPlanRequest;
use App\Repositories\Plans\PlanRepository;
use App\Services\PlanService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class AssignPlanController extends Controller
{
    private PlanService $planService;

    public function __construct()
    {
        $this->planService = new PlanService(new PlanRepository(new UserService()));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignPlanRequest $assignPlanRequest)
    {
        $response = $this->planService->assignPlanToUser($assignPlanRequest->validated());
        if (!$response) {
            return new JsonResponse([
                'status' => Http::BAD_REQUEST(),
                'data' => null,
                'message' => 'Erros encontrados.'
        ], Http::BAD_REQUEST());

        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => $response,
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
