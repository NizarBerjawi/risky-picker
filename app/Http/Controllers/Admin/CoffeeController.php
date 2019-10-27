<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coffee;
use App\Http\Requests\Coffee\{CreateCoffee, UpdateCoffee};
use App\Http\Controllers\Controller;

class CoffeeController extends Controller
{
    /**
     * Display a listing of the available coffee resources.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $coffees = Coffee::query()->paginate(10);

        return view('admin.coffees.index', compact('coffees'));
    }

    /**
     * Show the form for creating a new coffee resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.coffees.create');
    }

    /**
     * Store a new coffee resource.
     *
     * @param  \App\Http\Requests\Coffee\CreateCoffee  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCoffee $request)
    {
        Coffee::create($request->all());

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()
            ->route('admin.coffees.index')
            ->withSuccess($this->messages);
    }


    /**
     * Show the details of the coffee resource.
     *
     * @param \App\Models\Coffee  $coffee
     * @return \Illuminate\View\View
     */
    public function show(Coffee $coffee)
    {
        return view('admin.coffees.show', compact('coffee'));
    }

    /**
     * Show the form for editing a coffee resource.
     *
     * @param \App\Models\Coffee  $coffee
     * @return \Illuminate\View\View
     */
    public function edit(Coffee $coffee)
    {
        return view('admin.coffees.edit', compact('coffee'));
    }

    /**
     * Update a coffee resource.
     *
     * @param  \App\Http\Requests\Coffee\UpdateCoffee  $request
     * @param  \App\Models\Coffee  $coffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCoffee $request, Coffee $coffee)
    {
        $coffee->update($request->all());

        $this->messages->add('updated', trans('messages.coffee.updated'));

        return redirect()
            ->route('admin.coffees.index')
            ->withSuccess($this->messages);
    }

    /**
     * Confirm that an admin really wants to delete a coffee
     * resource
     *
     * @param  \App\Models\Coffee  $coffee
     * @return \Illuminate\View\View
     */
    public function confirmDestroy(Coffee $coffee)
    {
        return view('admin.coffees.delete', compact('coffee'));
    }

    /**
     * Delete a coffee resource
     *
     * @param  \App\Models\Coffee  $coffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Coffee $coffee)
    {
        $coffee->delete();

        $this->messages->add('deleted', trans('messages.coffee.deleted'));

        return redirect()
            ->route('admin.coffees.index')
            ->withSuccess($this->messages);
    }
}
