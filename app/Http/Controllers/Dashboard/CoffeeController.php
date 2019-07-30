<?php

namespace App\Http\Controllers\Dashboard;

use Picker\{Coffee, CoffeeRun, UserCoffee};
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

        $adhoc = $request->get('is_adhoc', false);

        if ($adhoc && !$request->hasValidSignature()) { abort(401); }

        return response()->view('dashboard.coffee.create', compact('adhoc'));
    }

    /**
     * Store a new coffee entry for the user.
     *
     * @param CreateUserCoffee $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserCoffee $request)
    {
        if ($request->user()->cant('create', UserCoffee::class)) {
            return back()->withErrors(trans('messages.coffee.auth'));
        }
        // Find the type of coffee the user is attempting to create
        $coffee = Coffee::findBySlugOrFail($request->input('name'));

        // Create a valid user coffee (or adhoc coffee) with all its details
        $userCoffee = UserCoffee::create([
            'user_id'    => $request->user()->id,
            'coffee_id'  => $coffee->id,
            'sugar'      => $request->input('sugar', 0),
            'start_time' => $request->input('start_time', now()->format('G:i')),
            'end_time'   => $request->input('end_time', now()->format('G:i')),
            'days'       => $request->input('days', [strtolower(now()->shortEnglishDayOfWeek)]),
            'is_adhoc'   => $request->input('is_adhoc', false),
        ]);

        // If the user is creating an adhoc coffee, then
        // the user is replacing one of their default coffees
        // with an adhoc one in a specific coffee run
        if ($userCoffee->is_adhoc) {
            $run = CoffeeRun::findOrFail($request->get('run_id'));
            $run->userCoffees()->updateExistingPivot($request->get('id'), [
                'user_coffee_id' => $userCoffee->id
            ]);
        }

        $this->messages->add('created', trans('messages.coffee.created'));

        // If this is an adhoc coffee being created, we need to redirect
        // the user back to the related coffee run page.
        $route = $request->get('is_adhoc')
            ? route('index', $run)
            : route('dashboard.index');

        return redirect($route)
                  ->withSuccess($this->messages);
    }

    public function show(UserCoffee $userCoffee)
    {
        return response()->view('dashboard.coffee.show', compact('userCoffee'));
    }

    /**
     * Display the form for editing the authenticated user's
     * details.
     *
     * @param Request $request
     * @param UserCoffee $userCoffee
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, UserCoffee $userCoffee)
     {
         $this->authorize('update', $userCoffee);

         $adhoc = $request->get('is_adhoc', false);

         return response()->view('dashboard.coffee.edit', compact('userCoffee', 'adhoc'));
     }

     /**
      * Update the user's coffee
      *
      * @param UpdateUserCoffee $request
      * @param UserCoffee $userCoffee
      * @return \Illuminate\Http\RedirectResponse
      */
      public function update(UpdateUserCoffee $request, UserCoffee $userCoffee)
      {
          $this->authorize('update', $userCoffee);

          $coffee = Coffee::findBySlugOrFail($request->input('name'));

          if ($userCoffee->isNotOfType($coffee)) {
              $userCoffee->coffee()->associate($coffee);
          };

          $userCoffee->fill($request->except('name'))->save();

          $this->messages->add('updated', trans('messages.coffee.updated'));

          return redirect()
                    ->route('dashboard.index')
                    ->withSuccess($this->messages);
      }

      /**
       * Delete a user's coffee
       *
       * @param Request $request
       * @param UserCoffee $userCoffee
       * @return \Illuminate\Http\RedirectResponse

       */
      public function destroy(Request $request, UserCoffee $userCoffee)
      {
          $this->authorize('delete', $userCoffee);

          $userCoffee->delete();

          $this->messages->add('deleted', trans('messages.coffee.deleted'));

          return back()->withSuccess($this->messages);
      }
}
