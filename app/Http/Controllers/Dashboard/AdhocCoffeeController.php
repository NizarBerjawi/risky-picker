<?php

namespace App\Http\Controllers\Dashboard;

use Picker\{CoffeeRun, AdhocUserCoffee, UserCoffee};
use Picker\CoffeeRun\Events\AdhocCoffeeCreated;
use Picker\UserCoffee\Requests\CreateUserCoffee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdhocCoffeeController extends Controller
{
    /**
     * Show the form for creating an adhoc user coffee.
     *
     * @param Request $request
     * @param CoffeeRun $run
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, CoffeeRun $run)
    {
        if (!$request->hasValidSignature()) { abort(401); }

        if ($request->user()->cant('create', UserCoffee::class)) {
            return back()->withErrors(trans('messages.coffee.auth'));
        }

        return response()->view('dashboard.coffee.create', compact('run'));
    }

    /**
     * Store a new adhoc coffee entry for the user.
     *
     * @param CreateUserCoffee $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserCoffee $request, CoffeeRun $run)
    {
        if ($request->user()->cant('create', UserCoffee::class)) {
            return back()->withErrors(trans('messages.coffee.auth'));
        }

        $userCoffee = new AdhocUserCoffee($request->all());
        $userCoffee->user()->associate($request->user());
        $userCoffee->save();

        event(new AdhocCoffeeCreated($run, $userCoffee));

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()
                  ->route('index', $run)
                  ->withSuccess($this->messages);
    }
}
