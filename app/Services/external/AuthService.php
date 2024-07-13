<?php

namespace App\Services\external;

use App\Models\User;

class AuthService
{
    public function generateToken(User $user)
    {
        $token = $user->createToken('authToken')->plainTextToken;
        return $token;

    }

}
