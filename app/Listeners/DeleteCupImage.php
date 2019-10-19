<?php

namespace App\Listeners;

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
     * @return void
     */
    public function handle($event)
    {
        $event->cup->deleteImage();
        $event->cup->deleteThumbnail();
    }
}
