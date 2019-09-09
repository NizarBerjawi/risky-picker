<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cup;
use App\Support\CupManager;
use App\Http\Requests\Cup\CupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class CupController extends Controller
{
    /**
     * Cup Manager responsible for uploading photos
     *
     * @var  \App\Support\CupManager
     */
    protected $manager;

    /**
     * Instantiate the controller
     *
     * @param  \App\Support\CupManager
     * @param  \Illuminate\Support\MessageBag
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
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.cups.create');
    }

    /**
     * Store a user's cup.
     *
     * @param  \App\Http\Requests\Cup\CupRequest  $request
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
     * @param  \App\Models\Cup  $cup
     * @return \Illuminate\View\View
     */
    public function show(Cup $cup)
    {
        return view('dashboard.cups.show', compact('cup'));
    }

    /**
     * Display the form for updating a cup photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cup $cup
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Cup $cup)
    {
        if ($request->user()->cant('update', $cup)) {
            return back()->withErrors(trans('messages.cup.auth'));
        }

        return view('dashboard.cups.edit', compact('cup'));
    }

    /**
     * Store or update a user's cup.
     *
     * @param  \App\Http\Requests\Cup\CupRequest  $request
     * @param  \App\Models\Cup  $cup
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cup  $cup
     * @return \Illuminate\View\View
     */
    public function confirmDestroy(Request $request, Cup $cup)
    {
        if ($request->user()->cant('delete', $cup)) {
            return back()->withErrors(trans('messages.cup.auth'));
        }

        return view('dashboard.cups.delete', compact('cup'));
    }

    /**
     * Delete a user's cup
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cup  $cup
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
