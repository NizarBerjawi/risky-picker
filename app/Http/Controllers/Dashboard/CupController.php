<?php

namespace App\Http\Controllers\Dashboard;

use Picker\Cup;
use Picker\Cup\CupManager;
use Picker\Cup\Requests\CupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class CupController extends Controller
{
    /**
     * Cup Manager responsible for uploading photos
     *
     * @var CupManager
     */
    protected $manager;

    /**
     * Instantiate the controller
     *
     * @param CupManager
     * @param MessageBag
     * @return void
     */
    public function __construct(CupManager $manager, MessageBag $messages)
    {
        parent::__construct($messages);

        $this->manager = $manager;
    }

    /**
     * Show a listing of all the user's cups
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cup = $request->user()->cup;

        return response()->view('dashboard.cups.index', compact('cup'));
    }

    /**
     * Display the form for creating a cup
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return response()->view('dashboard.cups.create');
    }

    /**
     * Store or update a user's cup.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CupRequest $request)
    {
        $user = $request->user();

        $path = $this->manager->handleFileUpload($request);

        if (!$path) {
            return back()->withError(trans('messages.cup.failed'));
        }

        $user->cup()->create(['filename' => $path]);

        $this->messages->add('updated', trans('messages.cup.created'));

        return redirect()
                ->route('dashboard.cups.index')
                ->withSuccess($this->messages);
    }

    /**
     * Display the form for uploading a cup photo
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cup $cup)
    {
        $this->authorize('update', $cup);

        return response()->view('dashboard.cups.edit', compact('cup'));
    }

    /**
     * Store or update a user's cup.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CupRequest $request, Cup $cup)
    {
        $this->authorize('update', $cup);

        $path = $this->manager->handleFileUpload($request);

        if (!$path) {
            return back()->withError(trans('messages.cup.failed'));
        }

        // Delete any old images
        $this->manager->handleFileDelete($cup->filename);

        $cup->update(['filename' => $path]);

        $this->messages->add('updated', trans('messages.cup.updated'));

        return back()
                ->withSuccess($this->messages);
    }

    /**
     * Delete a user's cup
     *
     * @param Request $request
     * @param Cup $cup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Cup $cup)
    {
        $this->authorize('delete', $cup);

        $cup->delete();

        $this->messages->add('updated', trans('messages.cup.deleted'));

        return back()
                ->withSuccess($this->messages);
    }
}
