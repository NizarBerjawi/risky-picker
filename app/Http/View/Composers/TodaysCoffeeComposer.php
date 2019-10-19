<?php

namespace App\Http\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class TodaysCoffeeComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $todaysCoffee = request()->user()
            ->userCoffees()
            ->today()
            ->get();

        $view->with(compact('todaysCoffee'));
    }
}
