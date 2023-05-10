<?php

namespace App\Repositories\Plans;

use App\Models\Plan\Plan;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\PlanService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class PlanRepository
{
    private array $defaultHeaders;
    private UserService $userService;
    private string $url = "";
    private string $urlToResponse = "";

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->defaultHeaders = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Accept' => 'application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1',
            'Authorization' => 'Bearer '.env('PAG_SEGURO_TOKEN')
        ];
        $this->url = env('PAG_SEGURO_URL')."/pre-approvals/request/?email=".env('PAG_SEGURO_EMAIl')."&token=".env('PAG_SEGURO_TOKEN');
        $this->urlToResponse = "https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code=";
    }


    public function assignPlanToUser(array $data)
    {
        $user = $this->userService->findById(auth()->user()->id);
        $plan = Plan::query()->find($data['plan_id']);
        $date = Carbon::now('UTC')->addYear()->setTimezone('UTC')->format('Y-m-d\T00:00:00\0-03:00');

        $response = Http::withHeaders($this->defaultHeaders)
            ->post($this->url, [
                "reference" => Carbon::now('UTC')->format('d_m_Y').'_'.$plan->name,
                'sender' => [
                    'name' => $user->social_name ?? $user->name,
                    'email' => 'yoramn.dev@outlook.com',
                    'address' => [
                        'street' => $data['address'],
                        'number' => $data['number'],
                        'complement' => $data['complement'],
                        'district' => $data['district'],
                        'postalCode' => $data['cep'],
                        'city' => $data['uf'],
                        'state' => $data['uf'],
                        'country' => $data['locality']
                    ]
                ],
                'preApproval' => [
                    'charge' => 'AUTO',
                    'name' => strtoupper('ASSINATURA').' '.$plan->name,
                    'details' => $plan->description,
                    'amountPerPayment' => $plan->price,
                    'period' => $plan->type->key,
                    'finalDate' => $date,
                    'maxTotalAmount' => $plan->price,
                ],
                'notification_urls' => 'http://localhost:80/ei_comece/public/api/pag-seguro-callback'
            ])
            ->body();

        dd($response);

        if(!$response) return false;

        $user->plan()->associate($plan)->save();
        $user->address()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'cep' => $data['cep'],
                'address' => $data['address'],
                'complement' => $data['complement'],
                'number' => $data['number'],
                'district' => $data['district'],
                'uf' => $data['uf'],
                'locality' => $data['locality']
            ]
        );
        $user->update(['code_plan' => $response['code']]);
        $response['link'] = $this->urlToResponse.$response['code'];
        $response['user'] = $user;
        return $response;
    }
}
