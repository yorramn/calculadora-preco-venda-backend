<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(new User());
    }

    public function findAll(?array $params) : \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->findAll($params, null, null);
    }

    public function findByEmail(string $email) : Model|User {
        return $this->userRepository->findByEmail($email);
    }

    public function findByToken(string $token) : Model|User {
        return $this->userRepository->findByToken($token);
    }

    public function findById(int $id) : Model|User {
        return $this->userRepository->findById($id);
    }
}
