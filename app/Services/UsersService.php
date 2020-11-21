<?php

namespace App\Services;

use App\Events\UserAccountCreated;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as ProviderUser;

class UsersService
{
    /**
     * Create a user and return
     *
     * @param array $data
     * @return User
     */
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

    /**
     * Authenticate a user and send a JsonResponse
     *
     * @param array $data
     * @return void
     */
    public function authenticateUser(array $data): JsonResponse
    {
        if (!Auth::attempt($data)) {
            return response(['message' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'user' => new UserResource(Auth::user()),
            'token' => $token,
        ]);
    }

    /**
     * Login and access a token to the user
     *
     * @param User $user
     * @return string
     */
    public function authenticateSocialUser(User $user): string
    {
        Auth::login($user);

        return $user->createToken('authToken')->accessToken;
    }

    /**
     * Create a new user from Socialite user account
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     * @return User
     */
    public function createNewUserFromSocialAccount(ProviderUser $providerUser, string $provider)
    {
        $nameParts = collect($providerUser->getName());

        $user = User::firstOrCreate([
            'email' => $providerUser->getEmail(),
        ], [
            'first_name' => $nameParts->first(),
            'last_name' => $nameParts->last(),
            'email' => $providerUser->getEmail(),
        ]);
        
        $user->linkedSocialAccounts()->create([
            'user_id' => $user->id,
            'provider_name' => $provider,
            'provider_id' => $providerUser->getId(),
        ]);

        $user->profile()->create();
        $user->profile
            ->addMediaFromUrl($providerUser->avatar)
            ->toMediaCollection('profile_image');
        
        return $user;
    }
}
