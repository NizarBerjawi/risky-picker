<?php

namespace App\Http\Controllers;

use Picker\Coffee\Coffee;
use Picker\Coffee\Requests\{CreateCoffee, UpdateCoffee};
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Http\{Response, Request, RedirectResponse};

class CoffeeController extends Controller
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
     * Display a listing of the available coffee types
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $coffees = Coffee::paginate(5);

        return response()->view('admin.coffees.index', compact('coffees'));
    }

    /**
     * Show the form for creating a new coffee.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request) : Response
    {
        return response()->view('admin.coffees.create');
    }

    /**
     * Store a new coffee resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CreateCoffee $request) : RedirectResponse
    {
        $coffee = Coffee::create($request->only(['name', 'description']));

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()->route('coffees.index')
                         ->withSuccess($this->messages);
    }

    /**
     * Show the form coffee details.
     *
     * @param Request $request
     * @param Coffee $coffee
     * @return Response
     */
    public function show(Request $request, Coffee $coffee) : Response
    {
        return response()->view('admin.coffees.show', compact('coffee'));
    }

    /**
     * Show the form for editing a coffee resource.
     *
     * @param Request $request
     * @param Coffee $coffee
     * @return Response
     */
    public function edit(Request $request, Coffee $coffee) : Response
    {
        return response()->view('admin.coffees.edit', compact('coffee'));
    }

    /**
     * Update a coffee resource.
     *
     * @param Request $request
     * @param Coffee $coffee
     * @return RedirectResponse;
     */
    public function update(UpdateCoffee $request, Coffee $coffee) : RedirectResponse
    {
        $coffee->update($request->only(['name', 'description']));

        $this->messages->add('updated', trans('messages.coffee.updated'));

        return redirect()->route('coffees.index')
                         ->withSuccess($this->messages);
    }

    /**
     * Delete a coffee resource
     *
     * @param Coffee $coffee
     * @return RedirectResponse;

     */
    public function destroy(Request $request, Coffee $coffee) : RedirectResponse
    {
        $coffee->delete();

        $this->messages->add('deleted', trans('messages.coffee.deleted'));

        return redirect()
                ->route('coffees.index')
                ->withSuccess($this->messages);
    }
}
