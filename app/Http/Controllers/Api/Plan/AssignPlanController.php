<?php

namespace App\Http\Controllers\Api\Plan;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;

class AssignPlanController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $this->planService->assignPlanToUser();
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
