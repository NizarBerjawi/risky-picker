<?php

namespace App\Listeners;

use App\Events\CupUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteCupImage
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
     * @param  CupUpdated  $event
     * @return void
     */
    public function handle($event)
    {
        $event->cup->deleteImage();
    }
}
