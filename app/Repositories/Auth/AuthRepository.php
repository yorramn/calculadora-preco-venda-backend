<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends \App\Repositories\BaseRepository
{
    /**
     * @param $user
     * @return string
     */
    public function generateToken($user) : string
    {
        return $user->createToken('authtoken')
            ->plainTextToken;
    }

    /**
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }
}
