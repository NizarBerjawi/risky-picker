<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\{CoffeeRun, Schedule};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get an instance of the user
        $user = $request->user();

        $cup = $user->cup()->first();

        $coffees = $user->userCoffees()
                        ->with('coffee')
                        ->paginate(3, ['*'], 'coffees');

        // Get the coffee runs that occured today
        $runs = CoffeeRun::thisWeek()
                         ->with(['user', 'volunteer', 'userCoffees'])
                         ->paginate(3, ['*'], 'runs');

        $countdown = Schedule::countdown();

        return response()->view('dashboard.index', compact('user', 'coffees', 'cup', 'runs', 'countdown'));
    }
}
