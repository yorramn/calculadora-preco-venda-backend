<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends \App\Repositories\BaseRepository
{
    public function findByEmail(string $email) : Model|User {
        return User::query()->whereEmail($email)->first();
    }
    public function findByToken(string $token) : Model|User {
        return User::query()->where('remember_token', $token)->first();
    }
}
