<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request) : JsonResponse {
        $users = $this->userService->findAll(null);
        if($users->count() <= 0){
            return new JsonResponse([
                'status' => Http::NO_CONTENT(),
                'data' => null,
                'message' => 'Não tem dados.'
            ], Http::NO_CONTENT());
        }
        return new JsonResponse([
            'status' => Http::OK(),
            'data' => $users,
            'message' => 'Dados encontrados.'
        ], Http::OK());
    }
}
