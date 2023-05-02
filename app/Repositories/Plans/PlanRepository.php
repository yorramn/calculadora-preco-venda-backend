<?php

namespace App\Repositories\Plans;

use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class PlanRepository extends \App\Repositories\BaseRepository
{

    public function assignPlanToUser(User|Model|Authenticatable $user) {
        $paymentService = new PaymentService();
        $paymentService->assignPlan();
        return $user->plan();
    }
}
