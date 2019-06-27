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
            // Set an expiry date for the coffee run URL
            $expires = now()->addDays(2);

            // Select a user to do the coffee run
            $user = Picker::pick(User::get());

            // Generate a new empty coffee run and associate it with the user
            $run = CoffeeRun::create(['user_id' => $user->id]);
            $url = URL::temporarySignedRoute('index', $expires, ['run_id' => $run->id]);
            $run->update(['signed_url' => $url]);

            // Get all the users who have a coffee in the next run
            $users = User::query()
                         ->whereHas('nextCoffee')
                         ->with('nextCoffee.coffee')
                         ->get();

            // Get all the ids of the users' next coffees
            $coffees = $users->pluck('nextCoffee.id');

            // Attach all the coffees to the coffee run
            $run->coffees()->attach($coffees->all());
        } catch (UnluckyUserNotFoundException $exception) {
            logger('warning', trans('messages.picker.fail'));
        }

        $user->notify(new UserPicked($run));
    }
}
