<?php

namespace Picker\User\Jobs;

use Picker\{CoffeeRUn, Picker, User};
use Picker\User\Notifications\UserPicked;

use Illuminate\Bus\Queueable;
use Illuminate\Support\{Collection, Str};
use Illuminate\Support\Facades\URL;
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
            // Select a user to do the coffee run
            $user = Picker::pick(User::withoutVIP()->get());

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
        } catch (UnluckyUserNotFoundException $exception) {
            logger('warning', trans('messages.picker.fail'));
        }

        $user->notify(new UserPicked($run));
    }
}
