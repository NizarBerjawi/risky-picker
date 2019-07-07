<?php

namespace App\Http\Controllers\Admin;

use Picker\Coffee;
use Picker\Coffee\Requests\{CreateCoffee, UpdateCoffee};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoffeeController extends Controller
{
    /**
     * Display a listing of the available coffee types
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coffees = Coffee::paginate(20);

        return response()->view('admin.coffees.index', compact('coffees'));
    }

    /**
     * Show the form for creating a new coffee.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.coffees.create');
    }

    /**
     * Store a new coffee resource.
     *
     * @param CreateCoffee $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCoffee $request)
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Coffee $coffee)
    {
        return response()->view('admin.coffees.edit', compact('coffee'));
    }

    /**
     * Update a coffee resource.
     *
     * @param UpdateCoffee $request
     * @param Coffee $coffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCoffee $request, Coffee $coffee)
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Coffee $coffee)
    {
        $coffee->delete();

        $this->messages->add('deleted', trans('messages.coffee.deleted'));

        return redirect()
                ->route('coffees.index')
                ->withSuccess($this->messages);
    }
}
