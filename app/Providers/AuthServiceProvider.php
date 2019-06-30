<?php

namespace App\Providers;

use Picker\{CoffeeRun, Cup, User, UserCoffee};
use Picker\Cup\Policies\CupPolicy;
use Picker\User\Policies\UserPolicy;
use Picker\UserCoffee\Policies\UserCoffeePolicy;
use Picker\CoffeeRun\Policy\CoffeeRunPolicy;
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
        CoffeeRun::class => CoffeeRunPolicy::class,

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
