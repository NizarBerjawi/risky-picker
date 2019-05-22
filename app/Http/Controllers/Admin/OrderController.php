<?php

namespace App\Http\Controllers\Admin;

use Picker\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\{Response, Request, RedirectResponse};

class OrderController extends Controller
{
    /**
     *
     */
    public function index(Request $request) : Response
    {
        $users = User::has('userCoffees')
                     ->with(['userCoffees', 'cup'])
                     ->paginate(5);

        return response()->view('admin.orders.index', compact('users'));
    }
}
