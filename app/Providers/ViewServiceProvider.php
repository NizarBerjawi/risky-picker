<?php

namespace App\Providers;

use App\Http\View\Composers\{CoffeeFormComposer, TodaysCoffeeComposer};
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
           [
               'admin.users.coffees.form',
               'dashboard.coffee.form',
           ], CoffeeFormComposer::Class
        );

        View::composer(
           'partials.options', TodaysCoffeeComposer::Class
        );
    }
}
