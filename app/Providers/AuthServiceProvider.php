<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models' => 'App\policies\ModelPolicies',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Passport::tokensExpireIn(now()->addHours(1)); 
        // Passport::personalAccessTokensExpireIn(now()->addHours(3)); 
        Passport::personalAccessTokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(1));


    }
    
}
