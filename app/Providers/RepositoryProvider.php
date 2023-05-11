<?php

namespace App\Providers;

use App\Interfaces\IEmailVerificationTokenRepository;
use App\Interfaces\IPersonalAccessTokenRepository;
use App\Interfaces\IRefreshTokenRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\EmailVerificationTokenRepository;
use App\Repositories\PersonalAccessTokenRepository;
use App\Repositories\RefreshTokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IRefreshTokenRepository::class,RefreshTokenRepository::class);
        $this->app->bind(IPersonalAccessTokenRepository::class,PersonalAccessTokenRepository::class);
        $this->app->bind(IEmailVerificationTokenRepository::class,EmailVerificationTokenRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
