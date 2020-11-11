<?php

namespace App\Services;

use App\Events\UserAccountCreated;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    public function createUser(array $data): User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new UserAccountCreated($user));

        return $user;
    }

    public function authenticateUser(array $data)
    {
        if (!Auth::attempt($data)) {
            return response(['message' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response([
            'user' => new UserResource(Auth::user()),
            'token' => $token,
        ]);
    }
}
