<?php

namespace App\Http\View\Composers;

use App\Coffee;
use Illuminate\View\View;

class CoffeeFormComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $coffees = Coffee::get();

        $sugars = [
            '0' => 'No sugar',
            '1' => 'One sugar',
            '2' => 'Two sugars',
            '3' => 'Three sugars',
        ];

        $days = [
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
        ];

        $view->with(compact('coffees', 'sugars', 'days'));
    }
}
