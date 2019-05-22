<?php

namespace App\Http\Controllers\Admin;

use Picker\Coffee;
use Picker\Coffee\Requests\{CreateCoffee, UpdateCoffee};
use App\Http\Controllers\Controller;
use Illuminate\Http\{Response, Request, RedirectResponse};

class CoffeeController extends Controller
{
    /**
     * Display a listing of the available coffee types
     *
     * @param Request $request
     * @return Response
     */
    public function index() : Response
    {
        $coffees = Coffee::paginate(3);

        return response()->view('admin.coffees.index', compact('coffees'));
    }

    /**
     * Show the form for creating a new coffee.
     *
     * @param Request $request
     * @return Response
     */
    public function create() : Response
    {
        return response()->view('admin.coffees.create');
    }

    /**
     * Store a new coffee resource.
     *
     * @param CreateCoffee $request
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
     * Show the form for editing a coffee resource.
     *
     * @param Coffee $coffee
     * @return Response
     */
    public function edit(Coffee $coffee) : Response
    {
        return response()->view('admin.coffees.edit', compact('coffee'));
    }

    /**
     * Update a coffee resource.
     *
     * @param UpdateCoffee $request
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
    public function destroy(Coffee $coffee) : RedirectResponse
    {
        $coffee->delete();

        $this->messages->add('deleted', trans('messages.coffee.deleted'));

        return redirect()
                ->route('coffees.index')
                ->withSuccess($this->messages);
    }
}
