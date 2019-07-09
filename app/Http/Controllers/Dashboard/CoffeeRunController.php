<?php

namespace App\Http\Controllers\Dashboard;

use Picker\{CoffeeRun, Picker, User};
use Picker\User\Notifications\UserPicked;
use Picker\CoffeeRun\Notifications\{VolunteerRequested, UserVolunteered};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoffeeRunController extends Controller
{
    /**
     * Display a listing of all coffee runs
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $runs = CoffeeRun::latest()
                         ->with(['user', 'volunteer', 'userCoffees'])
                         ->paginate(20);

        return response()->view('dashboard.runs.index', compact('runs'));
    }

    /**
     * Show a specified coffee run
     *
     * @NOTE: Not implemented yet
     *
     * @param Request $request
     * @param CoffeeRun $run
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CoffeeRun $run)
    {
        return response()->view('dashboard.runs.show', compact('run'));
    }

    /**
     * Update a specified coffee run user
     *
     * @param Request $request
     * @param CoffeeRun $run
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CoffeeRun $run)
    {
        $this->authorize('pick', $run);

        // Get the pool of users to select from while excluding the
        // user that was previously select for this coffee run
        $pool = User::exclude([$run->user])->withoutVIP()->get();

        // Randomly pick a user who is eligible to take this coffee run
        $user = Picker::pick($pool);

        // Attempt to update the coffee run's user
        if (!$run->changeUser($user)) {
            return back()->withErrors(trans('messages.run.failed'));
        }

        // Notify everyone in case of success
        $user->notify(new UserPicked($run));

        $this->messages->add('pick', trans('messages.run.pick'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Set the user who was selected to do the coffee run as busy
     *
     *
     * @param Request $request
     * @param CoffeeRun $run
     * @return \Illuminate\Http\RedirectResponse
     */
    public function busy(Request $request, CoffeeRun $run)
    {
        $this->authorize('busy', $run);

        $run->setBusyUser();

        $request->user()->notify(new VolunteerRequested($run));

        $this->messages->add('busy', trans('messages.run.busy'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Set a new volunteer user as the main initiater of the
     * coffee run.
     *
     * @param Request $request
     * @param CoffeeRun $run
     * @return \Illuminate\Http\RedirectResponse
     */
    public function volunteer(Request $request, CoffeeRun $run)
    {
        $this->authorize('volunteer', $run);

        $run->addVolunteer($request->user());

        $request->user()->notify(new UserVolunteered($run));

        $this->messages->add('busy', trans('messages.run.volunteer'));

        return back()->withSuccess($this->messages);
    }
}
