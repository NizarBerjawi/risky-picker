<?php

namespace App\Http\View\Composers;

use App\Models\Coffee;
use Illuminate\View\View;

class CoffeeFormComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
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

        $view->with(compact('coffees', 'sugars'));
    }
}
