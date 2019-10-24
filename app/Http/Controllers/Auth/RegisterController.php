<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessageBag $messages)
    {
        parent::__construct($messages);

        $this->middleware(['guest']);
        $this->middleware(['signed'])->only([
          'register', 'showRegistrationForm'
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,null,null,deleted_at,null'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $user = User::where('email', $request->get('email'))
            ->onlyTrashed()
            ->first();

        return view('auth.register', compact('user'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $details = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        // Check if the user already exists, if so, then
        // attempt to activate their account
        $success = $this->attemptToActivate($details);

        return $success ?: User::create($details);
    }

    /**
     * Atempt to activate a user's account if they
     * already have one.
     *
     * @param  array  $data
     * @return bool
     */
    public function attemptToActivate(array $data)
    {
        // Before we create the user, we check if the user
        // is soft-deleted in the database
        $user = User::where('email', $data['email'])
            ->onlyTrashed()
            ->first();

        if (!$user) { return false; }

        return $user->update(array_merge($data, [
            $user->getDeletedAtColumn() => null
        ]));
    }
}
