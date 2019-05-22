<?php

namespace App\Http\Controllers\Dashboard;

use Picker\{Coffee, User, UserCoffee};
use Picker\UserCoffee\Requests\{CreateUserCoffee, UpdateUserCoffee};
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, RedirectResponse};

class CoffeeController extends Controller
{
    /**
     * Show a listing of all the user's coffees
     *
     * @param Request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $coffees = $request->user()->userCoffees()->paginate(3);

        return response()
                ->view('dashboard.coffee.index', compact('coffees'));
    }

    /**
     * Show the form for creating a new user coffee.
     *
     * @return Response
     */
    public function create() : Response
    {
        $this->authorize('create', UserCoffee::class);

        return response()->view('dashboard.coffee.create');
    }

    /**
     * Store a new coffee entry for the user.
     *
     * @param CreateUserCoffee $request
     * @return RedirectResponse
     */
    public function store(CreateUserCoffee $request) : RedirectResponse
    {
        $user = $request->user();

        $this->authorize('create', UserCoffee::class);

        $coffee = Coffee::findBySlug($request->input('name'));

        $user->coffees()->attach($coffee, $request->except('name'));

        $this->messages->add('created', trans('messages.coffee.created'));

        return redirect()->route('dashboard.coffee.index')
                         ->withSuccess($this->messages);
    }

    /**
     * Display the form for editing the authenticated user's
     * details.
     *
     * @param Request $request
     * @param UserCoffee $userCoffee
     * @return Response
     */
     public function edit(Request $request, UserCoffee $userCoffee) : Response
     {
         $this->authorize('update', $userCoffee);

         return response()->view('dashboard.coffee.edit', compact('userCoffee'));
     }

     /**
      * Update the user's coffee
      *
      * @param UpdateUserCoffee $request
      * @param UserCoffee $userCoffee
      * @return RedirectResponse
      */
      public function update(UpdateUserCoffee $request, UserCoffee $userCoffee) : RedirectResponse
      {
          $this->authorize('update', $userCoffee);

          $coffee = Coffee::findBySlug($request->input('name'));

          if ($userCoffee->isNotOfType($coffee)) {
              $userCoffee->coffee()->associate($coffee);
          };

          $userCoffee->fill($request->except('name'))->save();

          $this->messages->add('updated', trans('messages.coffee.updated'));

          return redirect()
                    ->route('dashboard.coffee.index')
                    ->withSuccess($this->messages);
      }

      /**
       * Delete a user's coffee
       *
       * @param Request $request
       * @param UserCoffee $userCoffee
       * @return RedirectResponse;

       */
      public function destroy(Request $request, UserCoffee $userCoffee) : RedirectResponse
      {
          $this->authorize('delete', $userCoffee);

          $userCoffee->delete();

          $this->messages->add('deleted', trans('messages.coffee.deleted'));

          return back()->withSuccess($this->messages);
      }
}
