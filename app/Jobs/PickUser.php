<?php

namespace App\Jobs;

use App\Models\{CoffeeRun, Picker, User};
use App\Notifications\UserPicked;
use App\Exceptions\UnluckyUserNotFoundException;

use Illuminate\Bus\Queueable;
use Illuminate\Support\{Collection, Str};
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PickUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Get the pool of users to select from while excluding the
            // user that was previously selected for this coffee run
            $pool = User::canBePicked()->get();
            // Randomly pick a user who is eligible to take this coffee run
            $user = Picker::pick($pool);
            // Generate a new empty coffee run and associate it with the user
            $run = CoffeeRun::create(['user_id' => $user->id]);
            // Get all the users who have a coffee in the next run
            $users = User::query()
                         ->whereHas('nextCoffee')
                         ->with('nextCoffee.coffee')
                         ->get();
            // Get all the ids of the users' next coffees
            $userCoffees = $users->pluck('nextCoffee.id');
            // Attach all the coffees to the coffee run
            $run->userCoffees()->attach($userCoffees->all());
            // Send a notification about the user selection
            $user->notify(new UserPicked($run));
        } catch (UnluckyUserNotFoundException $exception) {
            logger(trans('messages.picker.fail'), [
                self::class
            ]);
        }

    }
}
