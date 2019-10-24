<?php

namespace App\Http\Controllers\Dashboard;

use Auth;
use App\Models\User;
use App\Http\Requests\User\UpdateUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the details of the user's profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return view('dashboard.user.show', compact('user'));
    }

    /**
     * Display the form for editing the authenticated user's
     * details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        if ($user->cant('update', $user)) {
            return back()->withErrors(trans('messages.user.auth'));
        }

        return view('dashboard.user.edit', compact('user'));
    }

    /**
     * Update the user's personal details
    *
    * @param  \App\Http\Requests\User\UpdateUser  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateUser $request)
    {
        $user = $request->user();

        if ($user->cant('update', $user)) {
            return back()->withErrors(trans('messages.user.auth'));
        }

        $user->update($request->only(['first_name', 'last_name']));

        $this->messages->add('updated', trans('messages.user.updated'));

        return redirect()
            ->route('dashboard.profile.show')
            ->withSuccess($this->messages);
    }

    /**
     * Confirm that a user really wants to delete their account
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function confirmDestroy(Request $request, User $user)
    {
        return view('dashboard.user.delete', compact('user'));
    }

    /**
     * Delete a user's account
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cup  $cup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->cant('delete', $user)) {
            return back()->withErrors(trans('messages.user.auth'));
        }

        // Soft delete and logout the user
        $user->delete();
        Auth::logout();

        $this->messages->add('deleted', trans('messages.user.deleted'));

        return redirect()
            ->route('login')
            ->withSuccess($this->messages);
    }
}
