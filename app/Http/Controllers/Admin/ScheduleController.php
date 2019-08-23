<?php

namespace App\Http\Controllers\Admin;

use Picker\Schedule;
use Picker\Schedule\Requests\{CreateSchedule, UpdateSchedule};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schedules = Schedule::paginate(20);

        return response()->view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.schedules.create');
    }

    /**
     * Store a new schedule resource.
     *
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSchedule $request)
    {
        $schedule = Schedule::create($request->all());

        $this->messages->add('created', trans('messages.schedule.created'));

        return redirect()->route('schedules.index')
                         ->withSuccess($this->messages);
    }

    /**
     * Show the details of a schedule resource.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return response()->view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing a schedule resource.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        return response()->view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update a coffee resource.
     *
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSchedule $request, Schedule $schedule)
    {
        $schedule->update($request->all());

        $this->messages->add('updated', trans('messages.schedule.updated'));

        return redirect()->route('schedules.index')
                         ->withSuccess($this->messages);
    }

    /**
     * Confirm that an admin really wants to delete a schedule
     *
     * @param Request $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmDestroy(Request $request, Schedule $schedule)
    {
        return response()->view('admin.schedules.delete', compact('schedule'));
    }

    /**
     * Delete a schedule resource
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        $this->messages->add('deleted', trans('messages.schedule.deleted'));

        return redirect()->route('schedules.index')
                         ->withSuccess($this->messages);
     }
}
