<?php

namespace App\Models;

use Carbon\Carbon;
use App\Support\Traits\{ExcludesFromQuery, HasDays};
use Illuminate\Database\Eloquent\{Builder, Model};

class Schedule extends Model
{
    use ExcludesFromQuery, HasDays;

    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'run_schedule';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'days' => 'array',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['days', 'time'];

    /**
     * The column that contains the days
     *
     * @var string
     */
    protected $daysColumn = 'days';

    /**
     * Get all user schedules that are scheduled on a
     * certain time.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $time  "G:i"  or "h:i A" time format
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAt(Builder $query, string $time)
    {
        $time = date("G:i", strtotime($time));

        return $query->whereRaw("time(time) = time('$time')");
    }

    /**
     * Get all schedules that are after a certain time
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $time  "G:i"  or "h:i A" time format
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAfter(Builder $query, string $time)
    {
        $time = date("G:i", strtotime($time));

        return $query->whereRaw("time(time) > time('$time')");
    }

    /**
     * Get the next schedule that is due today
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNextDueScheduleToday(Builder $query)
    {
        // Get the english day of today
        $today = strtolower(now()->shortEnglishDayOfWeek);
        // Check if there is any schedule today that could be executed
        return $query->days([$today])
            ->after(now()->format('G:i'))
            ->orderByRaw('time(time) ASC')
            ->limit(1);
    }

    /**
     * Get the schedule that will be executed next.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNextDueSchedule(Builder $query)
    {
        $schedule = (clone $query)->nextDueScheduleToday();

        if ($schedule->exists()) { return $schedule; }

        // Get the english day of tomorrow
        $tomorrow = strtolower(now()->addDays(1)->shortEnglishDayOfWeek);

        // If a schedule could not be found on the same day,
        // then get the first schedule expected to be run.
        foreach(days($start = $tomorrow) as $key => $day) {
            // Attempt to get the earliest schedule on a particular day,
            // other than today
            $schedule = (clone $query)->orderByRaw('time(time) ASC')
                                      ->days([$key]);
            // If a schedule is found, return that one
            if ($schedule->exists()) {
                return $schedule->limit(1);
            }
        }

        return $query;
    }

    /**
     * Get the time remaining until the next schedule is run
     * in human readable form
     *
     * @param Schedule $schedule
     * @return string
     */
    public static function countdown(Schedule $schedule = null)
    {
        // If a schedule is provided, compute the countdown
        // for it, otherwise use the next due schedule.
        $schedule = $schedule ?? static::nextDueSchedule()->first();
        // If there are no schedules available in the database,
        // or the user didn't supply one
        if (!$schedule) { return null; }
        // Get the english name of today
        $today = strtolower(now()->shortEnglishDayOfWeek);
        // The days available in the schedule. The order of the
        // days is modified to start from tomorrow
        $days = array_keys(array_only(days($start = $today), $schedule->days));
        // If the schedule doesn't have any time or days provided
        if (empty($days) || empty($schedule->time)) { return null; }

        while($day = array_shift($days)) {
            $time = Carbon::parse("{$day} {$schedule->time}");

            if ($day === $today && $time->lt(now())) {
                array_push($days, $day);
                continue;
            }

            if ($time->gt(now())) {
                return $time->diffForHumans();
            }

            return $time->addWeeks(1)->diffForHumans();
        }
    }

    /**
     * Set the time of this schedule
     *
     * @return void
     */
    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = date("G:i", strtotime($value));
    }

    /**
     * Get the time of this schedule
     *
     * @return string
     */
    public function getTimeAttribute($value)
    {
        return date("h:i A", strtotime($value));
    }
}
