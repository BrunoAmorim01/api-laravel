<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class UserRepository
{
    public function create($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function find(string $email)
    {
        return User::where('email', $email)->first();
    }
}
