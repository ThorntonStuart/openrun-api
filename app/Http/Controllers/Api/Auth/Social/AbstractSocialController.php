<?php

namespace App\Http\Controllers\Api\Auth\Social;

use App\Http\Controllers\Controller;
use App\Services\SocialUserResolverService;
use App\Services\UsersService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Two\GoogleProvider;

abstract class AbstractSocialController extends Controller
{
    /**
     * @var Factory
     */
    protected Factory $socialite;

    /**
     * @var SocialUserResolverService
     */
    protected SocialUserResolverService $socialUserResolverService;

    /**
     * @var UsersService
     */
    protected UsersService $usersService;

    public function __construct(
        Factory $socialite,
        SocialUserResolverService $socialUserResolverService,
        UsersService $usersService
    ) {
        $this->socialite = $socialite;
        $this->socialUserResolverService = $socialUserResolverService;
        $this->usersService = $usersService;
    }

    /**
     * Create a redirect to Facebook
     *
     * @return RedirectResponse
     */
    public function redirectToProvider()
    {
        return $this->getProvider()->stateless()->redirect();
    }

    /**
     * Create a redirect to Facebook
     *
     * @return RedirectResponse
     */
    public function handleProviderCallback()
    {
        try {
            $socialUser = $this->getProvider()->stateless()->user();
            $user = $this->socialUserResolverService->resolveUserByProviderCredentials(
                $this->providerName,
                $socialUser->token
            );

            $token = $this->usersService->authenticateSocialUser($user);

            return redirect(
                sprintf('%s%s%s', config('app.client_url'), 'confirm-auth?token=', $token)
            );
        } catch (ClientException $exception) {
            throw new FailedAuthorizationException(
                'Error occurs during external authorization',
                $exception->getCode(),
                $exception
            );
        }
    }
    
    /**
     * Returns provider instance for authorization process
     *
     * @return Provider|FacebookProvider|GoogleProvider
     */
    abstract protected function getProvider();
}
