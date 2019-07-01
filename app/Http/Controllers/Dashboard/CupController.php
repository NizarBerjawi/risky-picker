<?php

namespace App\Http\Controllers\Dashboard;

use Picker\Cup;
use Picker\Cup\CupManager;
use Picker\Cup\Requests\CupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Http\{Request, Response, RedirectResponse};

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
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $cup = $request->user()->cup;

        return response()->view('dashboard.cups.index', compact('cup'));
    }

    /**
     * Display the form for creating a cup
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request) : Response
    {
        return response()->view('dashboard.cups.create');
    }

    /**
     * Store or update a user's cup.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CupRequest $request) : RedirectResponse
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
     * @return Response
     */
    public function edit(Request $request, Cup $cup) : Response
    {
        $this->authorize('update', $cup);

        return response()->view('dashboard.cups.edit', compact('cup'));
    }

    /**
     * Store or update a user's cup.
     *
     * @param Request $request
     * @return Response
     */
    public function update(CupRequest $request, Cup $cup) : RedirectResponse
    {
        $this->authorize('update', $cup);

        $path = $this->manager->handleFileUpload($request);

        if (!$path) {
            return back()->withError(trans('messages.cup.failed'));
        }

        // If the new image was uploaded successfully,
        // delete the old image from storage
        $cup->deleteImage();

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
     * @return RedirectResponse
     */
    public function destroy(Request $request, Cup $cup) : RedirectResponse
    {
        $this->authorize('delete', $cup);

        $cup->delete();

        $this->messages->add('updated', trans('messages.cup.deleted'));

        return back()
                ->withSuccess($this->messages);
    }
}
