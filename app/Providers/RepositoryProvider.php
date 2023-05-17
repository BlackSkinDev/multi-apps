<?php

namespace App\Providers;

use App\Interfaces\ICompanyRepository;
use App\Interfaces\IEmailVerificationTokenRepository;
use App\Interfaces\IMagicLinkTokenRepository;
use App\Interfaces\IPasswordResetTokenRepository;
use App\Interfaces\IPersonalAccessTokenRepository;
use App\Interfaces\IRefreshTokenRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmailVerificationTokenRepository;
use App\Repositories\MagicLinkTokenRepository;
use App\Repositories\PasswordResetTokenRepository;
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
        $this->app->bind(IPasswordResetTokenRepository::class,PasswordResetTokenRepository::class);
        $this->app->bind(IMagicLinkTokenRepository::class,MagicLinkTokenRepository::class);
        $this->app->bind(ICompanyRepository::class,CompanyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
