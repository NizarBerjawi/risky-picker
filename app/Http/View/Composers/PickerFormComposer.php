<?php

namespace App\Http\View\Composers;

use Picker\User\User;
use Picker\Type\Type;
use Illuminate\View\View;

class PickerFormComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get all the users
        $users = User::get();
        // Get all the order types
        $types = Type::get();

        $view->with(compact('users', 'types'));
    }
}
