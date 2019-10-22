<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Blade, Request};
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require app_path('helpers.php');

        LengthAwarePaginator::defaultView('partials.pagination');

        Blade::directive('alert', function ($expression) {
            return "<?php echo
                '<div class=\"card-panel '.(".$expression. "=== 'success' ? 'green' : 'red').' lighten-3\">
                    <ul class=\"browser-default white-text\">'?>
                    <?php
                        foreach(session($expression)->all() as \$error) {
                            echo '<li><b>'.\$error.'</b></li>';
                        }
                    ?>
                    <?php echo '</ul>
                </div>'
            ?>";
        });

        Blade::if('success', function () {
            return session()->has('success');
        });

        Blade::if('errors', function () {
            return session()->has('errors');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
