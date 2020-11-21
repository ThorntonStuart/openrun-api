<?php

namespace App\Services;

use App\Models\User;
use App\Models\LinkedSocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountsService
{
    /**
     * @var UsersService $usersService
     */
    protected UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Create user and linked social account from Socialite user
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     * @return void
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider)
    {
        $linkedSocialAccount = LinkedSocialAccount::whereProviderName($provider)
            ->whereProviderId($providerUser->getId())
            ->first();

        $user = optional($linkedSocialAccount)->user 
            ?? $this->usersService->createNewUserFromSocialAccount($providerUser, $provider);
        
        return optional($linkedSocialAccount)->user 
            ?? User::firstOrCreate([
                'email' => $providerUser->getEmail(),
            ], [
                'first_name' => $providerUser->getName(),
                'last_name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(), 
            ]);
    }
}