<?php

namespace App\Http\Controllers;

use App\{User, Order, Type, Picker};
use App\Notifications\UserPicked;
use App\Http\Controllers\Controller;
use App\Exceptions\UnluckyUserNotFoundException;
use Illuminate\Support\MessageBag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\{Response, Request};

class PickerController extends Controller
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
     * Display the page that allows the user to randomly
     * pick a user to order.
     *
     * @return Response
     */
    public function index() : Response
    {
        return response()->view('index');
    }

    /**
     * Randomly pick a user from the list of pickable users.
     *
     * @param Request
     * @return RedirectResponse
     */
    public function pick(Request $request) : RedirectResponse
    {
        $type = Type::whereSlug($request->input('type'))->first();

        $users = User::whereIn('slug', $request->input('users'))->get();

        try {
            $picker = new Picker($users, $type);

            $user = $picker->pick();

        } catch (UnluckyUserNotFoundException $exception) {
            $this->messages->add('warning', trans('messages.picker.fail'));

            return back()
                ->withWarning($this->messages)
                ->withInput($request->only(['type', 'users']));
        }

        return redirect()->route('pick.user', compact('type', 'user'));
    }

    /**
     * Show the result of the random picker.
     *
     * @param Type $type
     * @param User $user
     * @return Response
     */
    public function show(Type $type, User $user) : Response
    {
        return response()->view('show', compact('type', 'user'));
    }

    /**
     * Confirm the select user that was picked by the random picker
     *
     * @param Type $type
     * @param User $user
     * @return RedirectResponse
     */
    public function confirm(Type $type, User $user) : RedirectResponse
    {
        $order = Order::create([
            'user_id' => $user->id,
            'type_id' => $type->id,
        ]);

        $user->notify(new UserPicked($order));

        $this->messages->add('found', trans('messages.picker.success'));

        return redirect()->route('picker')->withSuccess($this->messages);
    }
}
