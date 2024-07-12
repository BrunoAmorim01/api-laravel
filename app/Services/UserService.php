<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\external\MailerService;
use Auth;
use Illuminate\Auth\Authenticatable;

//use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private MailerService $mailer
        )
    {
        // Constructor logic here
    }

    public function create($data)
    {
        $password = $data["password"];

        $user = $this->userRepository->create([
            'name' => $data["name"],
            'email' => $data["email"],
            'password' => $password,
        ]);
        Auth::setUser($user);
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return null;
        }

        try {
            $this->mailer->sendWelcomeMail($user);

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ];
    }

}
