<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\external\AuthService;
use App\Services\external\MailerService;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Auth\Authenticatable;

//use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private MailerService $mailer,
        private AuthService $authService
    ) {

    }

    public function create($data)
    {
        $password = $data["password"];

        $user = $this->userRepository->create([
            'name' => $data["name"],
            'email' => $data["email"],
            'password' => $password,
        ]);

        $token = $this->authService->generateToken($user);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ];
    }

}
