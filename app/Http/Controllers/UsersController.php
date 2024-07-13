<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(private UserService $userService)
    {

    }
    public function createUser(CreateUserRequest $request)
    {
        $data = $request->only(["name", "email", "password"]);
        $user = $this->userService->create($data);
        return response()->json(
            $user
        );
    }

    public function login(Request $request)
    {

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Auth::login($request->user());
        $tokenGenerated = $request->user()->createToken('access_token');

        return $this->respondWithToken($tokenGenerated);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
        ]);
    }

}
