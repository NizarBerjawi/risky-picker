<?php

namespace App\Http\Controllers;

use Picker\{User, UserCoffee, Picker, CoffeeRun};
use Illuminate\Support\{Collection, Str};
use Picker\Order\Jobs\CreateOrder;
use App\Http\Controllers\Controller;
use App\Exceptions\UnluckyUserNotFoundException;
use Illuminate\Http\{Request, Response, RedirectResponse};

class CoffeeRunController extends Controller
{
    /**
     * Instantiate the controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('signed')->only('index');
    }

    /**
     * Display the page that allows the user to randomly
     * pick a user to order.
     *
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $run = CoffeeRun::where('id', $request->get('run_id'))
                        ->with(['coffees.user.cup'])
                        ->firstOrFail();


        return response()->view('index', compact('run'));
    }
}
