<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $registerRequest): \Illuminate\Http\JsonResponse
    {
        return $this->authService->register($registerRequest->validated());
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {
        $loginRequest->authenticate();
        return $this->authService->login($loginRequest);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->logout($request);
    }
}
