<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    public function assignPlan() {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' =>  'application/json',
            'Authorization' => 'Bearer '.env('PAGSEGURO_TOKEN')
        ])->post(env('PAGSEGURO_SANDBOX_URL').'/orders', $this->setPayloadToRequest());
        dd($response);
    }

    /**
     * @return array
     */
    private function setPayloadToRequest()  : array {
        return [
            "reference_id" => "ex-00001",
            "customer" => [
                "name" => "Jose da Silva",
                "email" => "email@test.com",
                "tax_id" => "12345678909",
                "phones" => [
                    [
                        "country" => "+55",
                        "area" => "11",
                        "number" => "989416584",
                        "type" => "MOBILE"
                    ]
                ]
            ],
            "items" => [
                [
                    "reference_id" => "referencia do item",
                    "name" => "nome do item",
                    "quantity" => 1,
                    "unit_amount" => 500
                ]
            ],
            "shipping" => [
                "address" => [
                    "street" => "Avenida Brigadeiro Faria Lima",
                    "number" => "1384",
                    "complement" => "apto 12",
                    "locality" => "Pinheiros",
                    "city" => "São Paulo",
                    "region_code" => "SP",
                    "country" => "BRA",
                    "postal_code" => "01452002"
                ]
            ],
            "charges" => [
                [
                    "reference_id" => "referencia da cobranca",
                    "description" => "descricao da cobranca",
                    "amount" => [
                        "value" => 500,
                        "currency" => "BRL"
                    ],
                    "payment_method" => [
                        "type" => "CREDIT_CARD",
                        "installments" => 1,
                        "capture" => true,
                        "card" => [
                            'number' => '4111111111111111',
                            'exp_month' => '12',
                            'exp_year' => '2030',
                            "security_code" =>  "123",
                            "holder" => [
                                "name" => "Jose da Silva"
                            ],
                            "store" => true
                        ]
                    ],
                    "recurring" => [
                        "type" => "INITIAL"
                    ]
                ]
            ]
        ];
    }
}
