<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRepository extends \App\Repositories\BaseRepository
{
    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
    {
        return User::query()->get()->except(Auth::user()->id);
    }

    public function findByEmail(string $email) : Model|User {
        return User::query()->whereEmail($email)->first();
    }
    public function findByToken(string $token) : Model|User {
        return User::query()->where('remember_token', $token)->first();
    }
}
