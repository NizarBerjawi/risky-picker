<?php

namespace App\Http\Controllers;

use Picker\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\{Response, Request};

class OrderController extends Controller
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
     *
     */
    public function index(Request $request) : Response
    {
        $users = User::has('userCoffees')
                     ->with(['userCoffees', 'cup'])
                     ->paginate(5);

        return response()->view('orders.index', compact('users'));
    }
}
