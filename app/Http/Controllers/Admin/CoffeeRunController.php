<?php

namespace App\Http\Controllers\Admin;

use Picker\CoffeeRun;
use App\Http\Controllers\Controller;
use Illuminate\Http\{Response, Request, RedirectResponse};

class CoffeeRunController extends Controller
{
    /**
     * Display a listing of all coffee runs
     *
     * @param Request $request
     * @return Response
     */
    public function index() : Response
    {
        $runs = CoffeeRun::with(['user', 'coffees'])->paginate(5);

        return response()->view('admin.runs.index', compact('runs'));
    }

}
