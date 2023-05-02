<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JustSteveKing\StatusCode\Http;

class AuthController extends Controller
{
    private AuthService $authService;
    private UserService $userService;
    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
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

    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email'
        ], $request->only(['email']));

        if(!$this->authService->resetPassword($data))
            return new JsonResponse([
                'error' => true,
                'message' => 'Email não enviado',
                'data' => null,
            ], Http::BAD_REQUEST());

        return new JsonResponse([
            'error' => false,
            'message' => 'Email enviado com sucesso!',
            'data' => null,
        ], Http::OK());
    }

    public function resetPasswordSend(Request $request){
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|confirmed'
        ], $request->only(['password','user_id']));
        $user = $this->userService->findById($data['user_id']);

        if(!$user)
            return new JsonResponse([
                'error' => true,
                'message' => 'Usuário não encontrado',
                'data' => null,
            ], Http::BAD_REQUEST());

        if(!$this->authService->resetPasswordSend($user, $data))
            return new JsonResponse([
                'error' => true,
                'message' => 'Senha não resetada',
                'data' => null,
            ], Http::BAD_REQUEST());

        return new JsonResponse([
            'error' => false,
            'message' => 'Senha resetada com sucesso!',
            'data' => [
                'user' => $user,
                'token' => $this->authService->generateToken($user)
            ],
        ], Http::OK());
    }

    public function resetPasswordverifyToken(string $token){
        $user = $this->userService->findByToken($token);
        if(!$user)
            return new JsonResponse([
                'error' => true,
                'message' => 'Toke não verificado',
                'data' => null,
            ], Http::BAD_REQUEST());

        return new JsonResponse([
            'error' => false,
            'message' => 'Token verificado!',
            'data' => $user,
        ], Http::OK());
    }
}
