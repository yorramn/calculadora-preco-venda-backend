<?php

namespace App\Services;

use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository(new User());
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function register(array $data): JsonResponse
    {
        $data['password'] = $this->authRepository->hashPassword($data['password']);
        $user = $this->authRepository->create($data);
        $token = $this->authRepository->generateToken($user);
        return new JsonResponse([
            'error' => false,
            'message' => 'Criado com sucesso',
            'data' => [
                'user' => new RegisterResource($user),
                'token' => $token
            ],
        ], Http::CREATED());
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function login($data) : JsonResponse
    {
        $user = $data->user();
        $token = $this->authRepository->generateToken($user);
        return new JsonResponse([
            'error' => false,
            'message' => 'Login',
            'data' => [
                'user' => new RegisterResource($user),
                'token' => $token
            ],
        ], Http::OK());
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function logout($request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return new JsonResponse([
            'error' => false,
            'message' => 'Deslogado',
            'data' => null,
        ], Http::OK());
    }
}
