<?php

namespace App\Http\Controllers\Admin;

use App\Models\{User, Role};
use App\Notifications\UserInvited;
use App\Http\Requests\User\{UpdateUser, InviteUser};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Notification, URL};
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->exclude([$request->user()])
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the details of a specific user resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(Request $request, User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Display the form to invite users to the application.
     *
     * @return \Illuminate\View\View
     */
    public function invitation()
    {
        return view('admin.users.invite');
    }

    /**
     * Send an invitation email to the specified email
     *
     * @param  \App\Http\Requests\User\InviteUser  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(InviteUser $request)
    {
        $email = $request->input('email');

        // Invitation emails expire within 2 days
        $expires = now()->addDays(2);

        // Generate a signed URL
        $url = URL::temporarySignedroute('register', $expires, [
            'email' => $email
        ]);

        Notification::route('mail', $email)->notify(new UserInvited($url));

        $this->messages->add('invited', trans('messages.user.invited'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Display the form for editing a user resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, User $user)
    {
        if ($request->user()->cant('updateSelf', $user)) {
            return back()->withErrors(trans('messages.user.selfUpdate'));
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update a user account.
     *
     * @param  \App\Http\Requests\User\UpdateUser  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $request, User $user)
    {
        if ($request->user()->cant('updateSelf', $user)) {
            return back()->withErrors(trans('messages.user.selfUpdate'));
        }

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'is_vip'     => (boolean) $request->input('is_vip'),
        ]);

        $role = $request->input('is_admin') ? 'admin' : 'user';

        $user->roles()->sync(
            Role::where('name', $role)->first()
        );

        $this->messages->add('updated', trans('messages.user.updated'));

        return redirect()
            ->route('admin.users.index')
            ->withSuccess($this->messages);
    }

    /**
     * Confirm that an admin really wants to delete a user
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function confirmDestroy(Request $request, User $user)
    {
        if ($request->user()->cant('updateSelf', $user)) {
            return back()->withErrors(trans('messages.user.selfUpdate'));
        }

        return view('admin.users.delete', compact('user'));
    }

    /**
     * Delete a specfied user resource
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->cant('updateSelf', $user)) {
            return back()->withErrors(trans('messages.user.selfUpdate'));
        }

        $user->delete();

        $this->messages->add('deleted', trans('messages.user.deleted'));

        return redirect()
            ->route('admin.users.index')
            ->withSuccess($this->messages);
    }
}
