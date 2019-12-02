<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Passport::routes();

        if (auth('api')->user()) {
            $expires_at = auth('api')->user()->expires_at;
        } else {
            $expires_at = (request()->get('expires_at')) ? 7 : 1;
        }

        Passport::personalAccessTokensExpireIn(now()->addDays($expires_at));
    }
}
