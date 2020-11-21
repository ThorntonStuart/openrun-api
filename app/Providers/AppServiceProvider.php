<?php

namespace App\Providers;

use App\Services\SocialUserResolverService;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered
     *
     * @var array
     */
    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolverService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
