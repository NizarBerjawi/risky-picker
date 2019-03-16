<?php

namespace App\Http\Controllers;

use App\{User, Coffee, Cup};
use App\Events\CupUpdated;
use App\Listeners\DeleteCupImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateUser, UpdateUser};
use Illuminate\Http\File;
use Illuminate\Support\MessageBag;
use Illuminate\Http\{Response, Request, RedirectResponse};

class UserController extends Controller
{
    /**
     * The location where cups should be uploaded
     *
     * @var string
     */
    const PATH = 'public/cups';

    /**
     * Messages to display to the user
     *
     * @param MessageBag $messages
     */
    private $messages;

    /**
     * Initialize the User Controller
     *
     * @param MessageBag $messages
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Display a listing of the users
     *
     * @param Request $request
     * @param User $suer
     * @return Response
     */
    public function index() : Response
    {
        $users = User::paginate(5);

        return response()->view('users.index', compact('users'));
    }

    /**
     * Show the user resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user) : Response
    {
        return response()->view('users.show', compact('user'));
    }

    /**
     * Display the form to create a user
     *
     * @return Response
     */
    public function create() : Response
    {
        return response()->view('users.create');
    }

    /**
     * Store a newly created user.
     *
     * @param CreateUser $request
     * @return RedirectResponse
     */
    public function store(CreateUser $request) : RedirectResponse
    {
        $user = User::create($request->only(['name', 'email']));

        if ($path = $this->handleFileUpload($request)) {
            $user->cup()->create(['file_path' => $path]);
        }

        $this->messages->add('created', trans('messages.user.created'));

        return redirect()
                ->route('users.index')
                ->withSuccess($this->messages);
    }

    /**
     * Display the form for editing a user resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user) : Response
    {
        return response()->view('users.edit', compact('user'));
    }

    /**
     * Update a user account.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUser $request,  User $user) : RedirectResponse
    {
        if ($user->hasCup() && $this->handleFileDelete($request, $user->cup)) {
            $this->messages->add('deleted', trans('messages.cup.deleted'));
            return back()->withSuccess($this->messages);
        }

        $user->fill($request->only(['name', 'email']))->save();

        if ($path = $this->handleFileUpload($request)) {
            $user->cup()->updateOrCreate([], ['file_path' => $path]);
        }

        $this->messages->add('updated', trans('messages.user.updated'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Delete a specfied user resource
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user) : RedirectResponse
    {
        $user->delete();

        $this->messages->add('deleted', trans('messages.user.deleted'));

        return redirect()
                ->route('users.index')
                ->withSuccess($this->messages);
    }

    /**
     * Handle a coffee cup image upload for the user
     *
     * @param Request $request
     * @return mixed
     */
    private function handleFileUpload(Request $request)
    {
        if (!$request->hasFile('cup_photo')) { return false; }

        $file = $request->file('cup_photo');

        if(!$file->isValid()) { return false; }

        return $file->store(static::PATH);
    }

    /**
     * Handle a coffee cup image delete action
     *
     * @param Cup $cup
     * @param Request $request
     * @return mixed
     */
    private function handleFileDelete(Request $request, Cup $cup)
    {
        if (!$request->has('delete_cup')) { return false; }

        return $cup->delete();
    }
}
