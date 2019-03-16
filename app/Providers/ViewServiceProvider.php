<?php

namespace App\Providers;

use App\Http\View\Composers\CoffeeFormComposer;
use App\Http\View\Composers\PickerFormComposer;
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
           'coffees.form', CoffeeFormComposer::Class
        );

        View::composer(
           'index', PickerFormComposer::Class
        );
    }
}
