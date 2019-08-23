<?php

namespace App\Http\Controllers\Dashboard;

use Picker\UserCoffee;
use Picker\UserCoffee\Requests\{CreateUserCoffee, UpdateUserCoffee};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoffeeController extends Controller
{
    /**
     * Show the form for creating a new user coffee.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->cant('create', UserCoffee::class)) {
            return back()->withErrors(trans('messages.coffee.auth'));
        }

        return response()->view('dashboard.coffee.create');
    }

    /**
     * Store a new user coffee entry.
     *
     * @param CreateUserCoffee $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserCoffee $request)
    {
        if ($request->user()->cant('create', UserCoffee::class)) {
            return back()->withErrors(trans('messages.coffee.auth'));
        }

        $userCoffee = new UserCoffee($request->all());
        $userCoffee->user()->associate($request->user());
        $userCoffee->save();

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()
                  ->route('dashboard.index')
                  ->withSuccess($this->messages);
    }

    /**
     * Show a user coffee entry.
     *
     * @param UserCoffee $userCoffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(UserCoffee $userCoffee)
    {
        return response()->view('dashboard.coffee.show', compact('userCoffee'));
    }

    /**
     * Display the form for editing a user coffee entry.
     *
     * @param Request $request
     * @param UserCoffee $userCoffee
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, UserCoffee $userCoffee)
     {
         $this->authorize('update', $userCoffee);

         return response()->view('dashboard.coffee.edit', compact('userCoffee'));
     }

     /**
      * Update a user's coffee entry
      *
      * @param UpdateUserCoffee $request
      * @param UserCoffee $userCoffee
      * @return \Illuminate\Http\RedirectResponse
      */
      public function update(UpdateUserCoffee $request, UserCoffee $userCoffee)
      {
          if ($request->user()->cant('update', $userCoffee)) {
              return back()->withErrors(trans('messages.coffee.auth'));
          }

          $userCoffee->update($request->all());

          $this->messages->add('updated', trans('messages.coffee.updated'));

          return redirect()
                    ->route('dashboard.index')
                    ->withSuccess($this->messages);
      }

      /**
       * Confirm that a user really wants to delete their coffee entry
       *
       * @param Request $request
       * @param UserCoffee $coffee
       * @return \Illuminate\Http\RedirectResponse
       */
      public function confirmDestroy(Request $request, UserCoffee $userCoffee)
      {
          if ($request->user()->cant('delete', $userCoffee)) {
              return back()->withErrors(trans('messages.coffee.auth'));
          }

          return response()->view('dashboard.coffee.delete', compact('userCoffee'));
      }

      /**
       * Delete a user's coffee entry.
       *
       * @param Request $request
       * @param UserCoffee $userCoffee
       * @return \Illuminate\Http\RedirectResponse
       */
      public function destroy(Request $request, UserCoffee $userCoffee)
      {
          if ($request->user()->cant('delete', $userCoffee)) {
              return back()->withErrors(trans('messages.coffee.auth'));
          }

          $userCoffee->delete();

          $this->messages->add('deleted', trans('messages.coffee.deleted'));

          return redirect()->route('dashboard.index')->withSuccess($this->messages);
      }
}
