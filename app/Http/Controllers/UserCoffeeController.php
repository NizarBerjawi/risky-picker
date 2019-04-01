<?php

namespace App\Http\Controllers;

use Picker\User\User;
use Picker\Coffee\Coffee;
use Picker\UserCoffee\UserCoffee;
use Picker\UserCoffee\Requests\{CreateUserCoffee, UpdateUserCoffee};
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Http\{Response, RedirectResponse};

class UserCoffeeController extends Controller
{
    /**
     * Messages to display to the user
     *
     * @param MessageBag $messages
     */
    public $messages;

    /**
     * Initialize the controller
     *
     * @param MessageBag $messages
     * @return void
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Display a listing of the user's coffee choices
     *
     * @param User $suer
     * @return Response
     */
    public function index(User $user) : Response
    {
        $coffees = $user->coffees()->paginate(5);

        return response()->view('users.coffees.index', compact('user', 'coffees'));
    }

    /**
     * Show the form for creating a new user coffee.
     *
     * @param User $suer
     * @return Response
     */
    public function create(User $user) : Response
    {
        return response()->view('users.coffees.create', compact('user'));
    }

    /**
     * Store a new coffee entry for the user.
     *
     * @param CreateUserCoffee $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(CreateUserCoffee $request, User $user) : RedirectResponse
    {
        $coffee = Coffee::findBySlug($request->input('name'));

        $user->coffees()->attach($coffee, $request->except('name'));

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()->route('users.coffees.index', $user)
                         ->withSuccess($this->messages);
    }

    /**
     * Show the form user's coffee selection details.
     *
     * @param User $user
     * @param Coffee $coffee
     * @return Response
     */
    public function show(User $user, UserCoffee $userCoffee) : Response
    {
        return response()->view('users.coffees.show', compact('user', 'userCoffee'));
    }

    /**
     * Show the form for editing a user coffee.
     *
     * @param User $user
     * @param Coffee $coffee
     * @return Response
     */
    public function edit(User $user, UserCoffee $userCoffee) : Response
    {
        return response()->view('users.coffees.edit', compact('user', 'userCoffee'));
    }

    /**
     * Update a user's coffee selection.
     *
     * @param UpdateUserCoffee $request
     * @param User $user
     * @param UserCoffee $userCoffee
     * @return RedirectResponse;
     */
    public function update(UpdateUserCoffee $request, User $user, UserCoffee $userCoffee) : RedirectResponse
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
     * @return RedirectResponse;

     */
    public function destroy(User $user, UserCoffee $userCoffee) : RedirectResponse
    {
        $userCoffee->delete();

        $this->messages->add('deleted', trans('messages.coffee.deleted'));

        return redirect()
                ->route('users.coffees.index', $user)
                ->withSuccess($this->messages);
    }
}
