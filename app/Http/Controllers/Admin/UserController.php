<?php

namespace App\Http\Controllers\Admin;

use Picker\{Coffee, Cup, User, Role};
use Picker\User\Notifications\UserInvited;
use Picker\User\Requests\{CreateUser, UpdateUser, InviteUser};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Notification, URL};
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::exclude([$request->user()])->paginate(20);

        return response()->view('admin.users.index', compact('users'));
    }

    /**
     * Display the form to invite users to the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function invitation()
    {
        return response()->view('admin.users.invite');
    }

    /**
     * Send an invitation email to the specified email
     *
     * @param InviteUser  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(InviteUser $request)
    {
        $email = $request->input('email');

        // Invitation emails expire within 2 days
        $expires = now()->addDays(2);

        // Generate a signed URL
        $url = URL::temporarySignedRoute('register', $expires, [
            'email' => $email
        ]);

        Notification::route('mail', $email)->notify(new UserInvited($url));

        $this->messages->add('invited', trans('messages.user.invited'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Display the form for editing a user resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->view('admin.users.edit', compact('user'));
    }

    /**
     * Update a user account.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $request, User $user)
    {
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
                ->route('users.index')
                ->withSuccess($this->messages);
    }


    /**
     * Confirm that an admin really wants to delete a user
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmDestroy(Request $request, User $user)
    {
        return response()->view('admin.users.delete', compact('user'));
    }

    /**
     * Delete a specfied user resource
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        $this->messages->add('deleted', trans('messages.user.deleted'));

        return redirect()
                ->route('users.index')
                ->withSuccess($this->messages);
    }
}
