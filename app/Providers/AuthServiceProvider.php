<?php

namespace App\Providers;

use App\Models\{CoffeeRun, Cup, User, UserCoffee};
use App\Policies\{CoffeeRunPolicy, CupPolicy, UserPolicy, UserCoffeePolicy};
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
