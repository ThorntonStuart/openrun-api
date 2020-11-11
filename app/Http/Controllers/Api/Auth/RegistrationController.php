<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UsersService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * @param UsersService $usersService
     */
    public UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->usersService->createUser($request->input());

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken('authToken')->accessToken,
        ]);
    }
}
