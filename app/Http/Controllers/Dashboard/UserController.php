<?php

namespace App\Http\Controllers\Dashboard;

use Picker\User;
use Picker\User\Requests\UpdateUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the form for editing the authenticated user's
     * details.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request)
     {
         $user = $request->user();

         $this->authorize('update', $user);

         return response()->view('dashboard.user.edit', compact('user'));
     }

     /**
      * Update the user's personal details
      *
      * @param Request $request
      * @return \Illuminate\Http\RedirectResponse
      */
      public function update(UpdateUser $request)
      {
          $user = $request->user();

          $this->authorize('update', $user);

          $user->update($request->only(['first_name', 'last_name']));

          $this->messages->add('updated', trans('messages.user.updated'));

          return redirect()
                    ->route('dashboard.profile.edit')
                    ->withSuccess($this->messages);
      }
}
