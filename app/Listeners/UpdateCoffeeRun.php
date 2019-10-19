<?php

namespace App\Listeners;

class UpdateCoffeeRun
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        // We replace the old coffee of the user in the coffee run
        // with the new adhoc coffee
        $newCoffee = $event->userCoffee;
        $oldCoffee = $event->run->getUserCoffee($newCoffee->user);

        $event->run->userCoffees()->updateExistingPivot(
            $oldCoffee->id, [
            'user_coffee_id' => $newCoffee->id
        ]);
    }
}
