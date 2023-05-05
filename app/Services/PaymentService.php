<?php

namespace App\Services;

use App\Enums\Payment\ProductTypePaymentEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    private array $defaultHeaders;

    public function __construct()
    {
        $this->defaultHeaders = [
            //'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'Content-Type' => 'application/json;charset=UTF-8',
            //'Accept' => 'application/json',
            'Accept' => 'application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1',
            'Authorization' => 'Bearer '.env('PAG_SEGURO_TOKEN')
        ];
    }

    public function assignPlan()
    {
        $url = "https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/request/?email=".env('PAG_SEGURO_EMAIl')
                ."&token=".env('PAG_SEGURO_TOKEN');
        $date = Carbon::now('UTC')
            ->addYear()
            ->setTimezone('UTC')
            ->format('Y-m-d\T00:00:00\0-03:00');

        $response = Http::withHeaders($this->defaultHeaders)
            ->post($url, [
            "reference" => "ex-00001",
            'sender' => [
                'name' => 'Teste',
                'email' => 'yoramn.dev@outlook.com',
                'address' => [
                    'street' => 'Rua teste',
                    'number' => '18',
                    'complement' => 'teste',
                    'district' => 'teste',
                    'postalCode' => '08050000',
                    'city' => 'São Paulo',
                    'state' => strtoupper('sp'),
                    'country' => 'BRA'
                ]
            ],
            'preApproval' => [
                'charge' => 'AUTO',
                'name' => 'Finalização da Assinatura',
                'details' => 'detalhes',
                'amountPerPayment' => '10.00',
                'period' => 'MONTHLY',
                'finalDate' => $date,
                'maxTotalAmount' => '10.00',
            ]
            ])->json();
//        $order_id = Http::withHeaders($this->defaultHeaders)
//            ->post("https://sandbox.api.pagseguro.com/orders", [
//            "customer" => [
//                "name" => "Jose da Silva",
//                "email" => "email@test.com",
//                "tax_id" => "12345678909",
//                "phones" => [
//                    [
//                        "country" => "55",
//                        "area" => "11",
//                        "number" => "999999999",
//                        "type" => "MOBILE"
//                    ]
//                ]
//            ],
//            "items" => [
//                [
//                    "name" => "nome do item",
//                    "quantity" => 1,
//                    "unit_amount" => 1
//                ]
//],
//            "shipping" => [
//                "address" => [
//                    "street" => "Avenida Brigadeiro Faria Lima",
//                    "number" => "1384",
//                    "complement" => "apto 12",
//                    "locality" => "Pinheiros",
//                    "city" => "São Paulo",
//                    "region_code" => "SP",
//                    "country" => "BRA",
//                    "postal_code" => "01452002"
//                ]
//            ],
//            "charges" => [
//                [
//                    "reference_id" => "referencia da cobranca",
//                    "description" => "descricao da cobranca",
//                    "amount" => [
//                        "value" => 500,
//                        "currency" => "BRL"
//                    ],
//                    "payment_method" => [
//                        "type" => "CREDIT_CARD",
//                        "installments" => 1,
//                        "capture" => true,
//                        "card" => [
//                            "number" => '4111111111111111',
//                            "exp_month" => '12',
//                            "exp_year" => '2030',
//                            "security_code" => "123",
//                            "holder" => [
//                                "name" => "Jose da Silva"
//                            ],
//                            "store" => true
//                        ]
//                    ],
//                    "recurring" => [
//                        "type" => "INITIAL"
//                    ]
//                ]
//            ],
//            "notification_urls" => [
//                "https://meusite.com/notificacoes"
//            ]
//            ])->json()['id'];

//        $response = Http::withHeaders($this->defaultHeaders)
//            ->post("https://sandbox.api.pagseguro.com/orders/ORDE_D7A6A1F3-67D4-4622-8377-5A5B3B74345F/pay", [
//                "charges" => [
//                    [
//                        "reference_id" => "referencia da cobranca",
//                        "description" => "descricao da cobranca",
//                        "amount" => [
//                            "value" => 500,
//                            "currency" => "BRL"
//                        ],
//                        "payment_method" => [
//                            "type" => "CREDIT_CARD",
//                            "installments" => 1,
//                            "capture" => true,
//                            "card" => [
//                                "number" => '4111111111111111',
//                                "exp_month" => '12',
//                                "exp_year" => '2030',
//                                "security_code" => "123",
//                                "holder" => [
//                                    "name" => "Jose da Silva"
//                                ],
//                                "store" => true
//                            ]
//                        ],
//                        "recurring" => [
//                            "type" => "INITIAL"
//                        ]
//                    ]
//                ]
//            ]);
        $response['link'] = "https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code=".$response['code'];
        return $response;
    }

}
