<?php

namespace App\Http\Controllers;

use Picker\{Coffee, CoffeeRun};
use Picker\UserCoffee\Filters\UserCoffeeFilters;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function __construct(UserCoffeeFilters $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Display the latest coffee run with the user coffees
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CoffeeRun $run)
    {
        abort_if($run->expired(), 410, trans('messages.run.expired'));

        // Get all the coffee types that are available in this run
        $coffeeTypes = Coffee::withCoffeeTotal($run)->get();

        // Get all the coffees in this coffee run and filter
        $userCoffees = $run->userCoffees()
                           ->filter($this->filters)
                           ->with(['coffee', 'user.cup'])
                           ->get();

        return response()->view('index', compact('run', 'coffeeTypes', 'userCoffees'));
    }
}
