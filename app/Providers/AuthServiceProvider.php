<?php

namespace Base\Providers;

use Broadcast;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Base\Model' => 'Base\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register Routes
        Passport::routes();

        // Access Tokens expire in 1 day
        Passport::tokensExpireIn(Carbon::now()->addDay());

        // Refresh Tokens expire in 15 days
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(15));

        // Scopes
        Passport::tokensCan(config('oauth2.scopes', []));
    }
}
