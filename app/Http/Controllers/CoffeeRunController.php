<?php

namespace App\Http\Controllers;

use App\Models\{Coffee, CoffeeRun, User};
use App\Filters\UserCoffeeFilters;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoffeeRunController extends Controller
{
    /**
     * User Coffee filters
     *
     * @var  \App\Filters\UserCoffeeFilters
     */
    protected $filters;

    /**
     * Instantiate the controller
     *
     * @param  \App\Filters\UserCoffeeFilters
     * @return void
     */
    public function __construct(UserCoffeeFilters $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Display the latest coffee run with the user coffees
     *
     * @param  \App\Models\CoffeeRun  $run
     * @return \Illuminate\View\View
     */
    public function index(CoffeeRun $run)
    {
        abort_if($run->expired(), 410, trans('messages.run.expired'));

        // Get all the coffee types that are available in this run
        $coffeeTypes = Coffee::withCoffeeTotal($run)->get();

        // Get all the coffees in this coffee run and filter
        $userCoffees = $run->userCoffees()
            ->filter($this->filters)
            ->with(['coffee', 'user.cup'])
            ->get();

        return view('index', compact('run', 'coffeeTypes', 'userCoffees'));
    }
}
