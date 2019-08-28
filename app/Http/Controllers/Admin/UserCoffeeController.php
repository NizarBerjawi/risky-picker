<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Coffee, User, UserCoffee};
use App\Http\Requests\UserCoffee\{CreateUserCoffee, UpdateUserCoffee};
use App\Http\Controllers\Controller;

class UserCoffeeController extends Controller
{
    /**
     * Display a listing of the user's coffee choices
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $coffees = $user->userCoffees()
                        ->with('coffee')
                        ->paginate(10);

        return view('admin.users.coffees.index', compact('user', 'coffees'));
    }

    /**
     * Show the form for creating a new user coffee.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function create(User $user)
    {
        return view('admin.users.coffees.create', compact('user'));
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
        $userCoffee = new UserCoffee($request->all());
        $userCoffee->user()->associate($user);
        $userCoffee->save();

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()
                ->route('users.coffees.index', $user)
                ->withSuccess($this->messages);
    }

    /**
     * Show the form for editing a user coffee.
     *
     * @param User $user
     * @param UserCoffee $userCoffee
     * @return \Illuminate\View\View
     */
    public function edit(User $user, UserCoffee $userCoffee)
    {
        return view('admin.users.coffees.edit', compact('user', 'userCoffee'));
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
        $userCoffee->update($request->all());

        $this->messages->add('updated', trans('messages.coffee.updated'));

        return redirect()
                ->route('users.coffees.index', $user)
                ->withSuccess($this->messages);
    }

    /**
     * Confirm that an admin really wants to delete a user coffee
     *
     * @param Request $request
     * @param Coffee $coffee
     * @return \Illuminate\View\View
     */
    public function confirmDestroy(User $user, UserCoffee $userCoffee)
    {
        return view('admin.users.coffees.delete', compact('user', 'userCoffee'));
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
