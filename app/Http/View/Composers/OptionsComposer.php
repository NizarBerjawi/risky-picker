<?php

namespace App\Http\View\Composers;

use Picker\User;
use Illuminate\View\View;

class OptionsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
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
