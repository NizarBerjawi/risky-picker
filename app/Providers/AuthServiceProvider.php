<?php

namespace App\Providers;

use Picker\{Cup, User, UserCoffee};
use Picker\Cup\Policies\CupPolicy;
use Picker\User\Policies\UserPolicy;
use Picker\UserCoffee\Policies\UserCoffeePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        UserCoffee::class => UserCoffeePolicy::class,
        Cup::class => CupPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
