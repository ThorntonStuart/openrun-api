<?php

namespace App\Services;

use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;

class SocialUserResolverService implements SocialUserResolverInterface
{
    /**
     * @var SocialAccountsService $socialAccountsService
     */
    protected SocialAccountsService $socialAccountsService;

    public function __construct(SocialAccountsService $socialAccountsService)
    {
        $this->socialAccountsService = $socialAccountsService;
    }

    /**
     * Resolve user by provider credentials
     *
     * @param string $provider
     * @param string $accessToken
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->userFromToken($accessToken);
        } catch (Exception $exception) {}

        return isset($providerUser) ? $this->socialAccountsService->findOrCreate($providerUser, $provider) : null;
    }
}