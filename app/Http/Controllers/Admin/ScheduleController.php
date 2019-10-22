<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Http\Requests\Schedule\{CreateSchedule, UpdateSchedule};
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $schedules = Schedule::query()->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Store a new schedule resource.
     *
     * @param  \App\Http\Requests\Schedule\CreateSchedule  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSchedule $request)
    {
        Schedule::create($request->all());

        $this->messages->add('created', trans('messages.schedule.created'));

        return redirect()
            ->route('admin.schedules.index')
            ->withSuccess($this->messages);
    }

    /**
     * Show the details of a schedule resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\View\View
     */
    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing a schedule resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\View\View
     */
    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update a coffee resource.
     *
     * @param  \App\Http\Requests\Schedule\UpdateSchedule  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSchedule $request, Schedule $schedule)
    {
        $schedule->update($request->all());

        $this->messages->add('updated', trans('messages.schedule.updated'));

        return redirect()
            ->route('admin.schedules.index')
            ->withSuccess($this->messages);
    }

    /**
     * Confirm that an admin really wants to delete a schedule
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\View\View
     */
    public function confirmDestroy(Schedule $schedule)
    {
        return view('admin.schedules.delete', compact('schedule'));
    }

    /**
     * Delete a schedule resource
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        $this->messages->add('deleted', trans('messages.schedule.deleted'));

        return redirect()
            ->route('admin.schedules.index')
            ->withSuccess($this->messages);
     }
}
