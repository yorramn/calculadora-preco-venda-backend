<?php

namespace App\Services;

use App\Http\Resources\Auth\RegisterResource;
use App\Mail\User\ResetPasswordMail;
use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JustSteveKing\StatusCode\Http;

class AuthService
{
    private AuthRepository $authRepository;
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->authRepository = new AuthRepository(new User());
        $this->userService = $userService;
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
        $token = $this->generateToken($user);

        return new JsonResponse([
            'error' => false,
            'message' => 'Login',
            'data' => [
                'user' => $user,
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

    public function resetPassword(array $data) : bool{
        $user = $this->userService->findByEmail($data['email']);
        if(!$user) return false;
        $user->setRememberToken(Str::replace('/', '', Hash::make($user->email)));
        if(!$user->fill([
            'remember_token' => Hash::make($user->email)
        ])->save()) return false;

        Mail::to($user)
            ->send(new ResetPasswordMail($user));
        return true;
    }

    public function resetPasswordSend(Model|User $user, array $data) : bool{
        if(!$user->update([
            'password' => Hash::make($data['password'])
        ])) return false;;
        return true;
    }

    /**
     * @param $user
     * @return string
     */
    public function generateToken($user): string
    {
        return $this->authRepository->generateToken($user);
    }
}
