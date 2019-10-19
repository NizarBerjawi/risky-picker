<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\{Coffee, CoffeeRun, Picker, Schedule, User, UserCoffee};
use App\Filters\UserCoffeeFilters;
use App\Notifications\{VolunteerRequested, UserVolunteered, UserPicked};
use App\Http\Controllers\Controller;
use App\Exceptions\UnluckyUserNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class CoffeeRunController extends Controller
{
    /**
     * User Coffee filters
     *
     * @var UserCoffeeFilters
     */
    protected $filters;

    /**
     * Instantiate the controller
     *
     * @return void
     */
    public function __construct(UserCoffeeFilters $filters, MessageBag $messages)
    {
        parent::__construct($messages);

        $this->filters = $filters;
    }

    /**
     * Show a listing of all the recent coffee runs
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the coffee runs that occured recently
        $runs = CoffeeRun::recent()
            ->latest('created_at')
            ->with([
                'user',
                'volunteer',
                'userCoffees' => function($query) {
                    return $query->withTrashed();
                }
            ])
            ->paginate(3);

        $countdown = Schedule::countdown();

        return response()->view('dashboard.runs.index', compact('runs', 'countdown'));
    }

    /**
     * Show a specified coffee run
     *
     * @param  \App\Models\CoffeeRun  $run
     * @return \Illuminate\View\View
     */
    public function show(CoffeeRun $run)
    {
        // Get all the coffee types that are available in this run
        $coffeeTypes = Coffee::withCoffeeTotal($run)->get();

        // Get all the coffees in this coffee run and filter
        $userCoffees = $run->userCoffees()
                           ->withTrashed()
                           ->filter($this->filters)
                           ->with([
                               'coffee' => function($query) {
                                   return $query->withTrashed();
                               },
                               'user.cup'
                            ])
                           ->get();

        return view('dashboard.runs.show', compact('run', 'coffeeTypes', 'userCoffees'));
    }

    /**
     * Update a specified coffee run user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoffeeRun  $run
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CoffeeRun $run)
    {
        $this->authorize('pick', $run);
        // Get the pool of users to select from while excluding the
        // user that was previously selected for this coffee run
        $pool = User::canBePicked()->get();
        // Randomly pick a user who is eligible to take this coffee run
        try {
            $user = Picker::pick($pool);
        } catch (UnluckyUserNotFoundException $exception) {
            return back()->withErrors(trans('messages.run.failed'));
        }

        $run->setUser($user);

        $user->notify(new UserPicked($run));

        $this->messages->add('pick', trans('messages.run.pick'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Set the user who was selected to do the coffee run as busy
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoffeeRun  $run
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoffeeRun  $run
     * @return \Illuminate\Http\RedirectResponse
     */
    public function volunteer(Request $request, CoffeeRun $run)
    {
        $this->authorize('volunteer', $run);

        $run->addVolunteer($request->user());

        $request->user()->notify(new UserVolunteered($run));

        $this->messages->add('volunteer', trans('messages.run.volunteer'));

        return back()->withSuccess($this->messages);
    }

    /**
     * Confirm that the user wants to remove their coffee from the run
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoffeeRun  $run
     * @param  \App\Models\UserCoffee  $coffee
     * @return \Illuminate\View\View
     */
    public function preRemove(Request $request, CoffeeRun $run, UserCoffee $coffee)
    {
        if ($request->user()->cant('remove', [$run, $coffee])) {
            return back()->withErrors(trans('messages.run.auth'));
        }

        return view('dashboard.runs.remove', compact('run', 'coffee'));
    }

    /**
     * Delete a user coffee from the coffee run
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoffeeRun  $run
     * @param  \App\Models\UserCoffee  $coffee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request, CoffeeRun $run, UserCoffee $coffee)
    {
        if ($request->user()->cant('remove', [$run, $coffee])) {
            return back()->withErrors(trans('messages.run.auth'));
        }

        $run->userCoffees()->detach($coffee);

        $this->messages->add('remove', trans('messages.run.remove'));

        return redirect()->route('index', $run)->withSuccess($this->messages);
    }
}
