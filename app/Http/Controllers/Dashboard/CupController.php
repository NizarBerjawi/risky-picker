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
     * Store a user's cup.
     *
     * @param CupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CupRequest $request)
    {
        $path = $this->manager->handleFileUpload($request);

        if (!$path) {
            return back()->withErrors(trans('messages.cup.failed'));
        }

        $request->user()->cup()->create(['filename' => $path]);

        $this->messages->add('updated', trans('messages.cup.created'));

        return redirect()
                ->route('dashboard.index')
                ->withSuccess($this->messages);
    }

    /**
     * Display the cup photo
     *
     * @param Cup $cup
     * @return \Illuminate\Http\Response
     */
    public function show(Cup $cup)
    {
        return response()->view('dashboard.cups.show', compact('cup'));
    }

    /**
     * Display the form for updating a cup photo
     *
     * @param Request $request
     * @param Cup $cup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cup $cup)
    {
        if ($request->user()->cant('update', $cup)) {
            return back()->withErrors(trans('messages.cup.auth'));
        }

        return response()->view('dashboard.cups.edit', compact('cup'));
    }

    /**
     * Store or update a user's cup.
     *
     * @param CupRequest $request
     * @param Cup $cup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CupRequest $request, Cup $cup)
    {
        if ($request->user()->cant('update', $cup)) {
            return back()->withErrors(trans('messages.cup.auth'));
        }

        $path = $this->manager->handleFileUpload($request);

        if (!$path) {
            return back()->withErrors(trans('messages.cup.failed'));
        }

        // Delete any old images
        $this->manager->handleFileDelete($cup->filename);

        $cup->update(['filename' => $path]);

        $this->messages->add('updated', trans('messages.cup.updated'));

        return redirect()
                ->route('dashboard.index')
                ->withSuccess($this->messages);
    }

    /**
     * Confirm that a user really wants to delete their cup
     *
     * @param Request $request
     * @param Cup $cup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmDestroy(Request $request, Cup $cup)
    {
        if ($request->user()->cant('delete', $cup)) {
            return back()->withErrors(trans('messages.cup.auth'));
        }

        return response()->view('dashboard.cups.delete', compact('cup'));
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
        if ($request->user()->cant('delete', $cup)) {
            return back()->withErrors(trans('messages.cup.auth'));
        }

        $cup->delete();

        $this->messages->add('deleted', trans('messages.cup.deleted'));

        return redirect()
                ->route('dashboard.index')
                ->withSuccess($this->messages);
    }
}
