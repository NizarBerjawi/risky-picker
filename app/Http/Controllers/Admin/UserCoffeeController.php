<?php

namespace App\Http\Controllers\Admin;

use Picker\{Coffee, User, UserCoffee};
use Picker\UserCoffee\Requests\{CreateUserCoffee, UpdateUserCoffee};
use App\Http\Controllers\Controller;

class UserCoffeeController extends Controller
{
    /**
     * Display a listing of the user's coffee choices
     *
     * @param User $suer
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $coffees = $user->userCoffees()
                        ->with('coffee')
                        ->paginate(20);

        return response()->view('admin.users.coffees.index', compact('user', 'coffees'));
    }

    /**
     * Show the form for creating a new user coffee.
     *
     * @param User $suer
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return response()->view('admin.users.coffees.create', compact('user'));
    }

    /**
     * Store a new coffee entry for the user.
     *
     * @param CreateUserCoffee $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserCoffee $request, User $user)
    {
        $coffee = Coffee::findBySlug($request->input('name'));

        $user->coffees()->attach($coffee, $request->except('name'));

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()->route('users.coffees.index', $user)
                         ->withSuccess($this->messages);
    }

    /**
     * Show the form for editing a user coffee.
     *
     * @param User $user
     * @param Coffee $coffee
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, UserCoffee $userCoffee)
    {
        return response()->view('admin.users.coffees.edit', compact('user', 'userCoffee'));
    }

    /**
     * Update a user's coffee selection.
     *
     * @param UpdateUserCoffee $request
     * @param User $user
     * @param UserCoffee $userCoffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserCoffee $request, User $user, UserCoffee $userCoffee)
    {
        $coffee = Coffee::findBySlug($request->input('name'));

        if ($userCoffee->isNotOfType($coffee)) {
            $userCoffee->coffee()->associate($coffee);
        };

        $userCoffee->fill($request->except('name'))->save();

        $this->messages->add('updated', trans('messages.coffee.updated'));

        return redirect()->route('users.coffees.index', $user)
                         ->withSuccess($this->messages);
    }

    /**
     * Delete a user's coffee selection
     *
     * @param User $user
     * @param UserCoffee $userCoffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user, UserCoffee $userCoffee)
    {
        $userCoffee->delete();

        $this->messages->add('deleted', trans('messages.coffee.deleted'));

        return redirect()
                ->route('users.coffees.index', $user)
                ->withSuccess($this->messages);
    }
}
