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

        Blade::directive('validation', function ($expression) {
            return
                '<?php if ($errors->has('.$expression.')): ?>' .
                    '<span class="helper-text" data-error="<?php echo $errors->first('.$expression.'); ?>"></span>' .
                '<?php endif; ?>';
        });

        Blade::directive('alert', function ($expression) {
            return "<?php echo
                '<div class=\"row\">
                    <div class=\"card-panel '.(".$expression. "=== 'success' ? 'green' : 'red').' lighten-3\">
                        <ul class=\"browser-default white-text\">'?>
                        <?php
                         foreach(session($expression)->all() as \$error) { echo '<li><b>'.\$error.'</b></li>'; }
                         ?>
                        <?php echo '</ul>
                    </div>
                </div>'
            ?>";
        });

        Blade::if('ondashboard', function () {
            return Request::is('dashboard*') && Auth::check();
        });

        Blade::if('onadmin', function () {
            return Request::is('admin*') && Auth::check() && Auth::user()->isAdmin();
        });

        Blade::if('success', function () {
            return session()->has('success');
        });

        Blade::if('warning', function () {
            return session()->has('warning');
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
