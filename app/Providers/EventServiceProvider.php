<?php

namespace App\Providers;

use App\Events\{AdhocCoffeeCreated, CupUpdated, CupDeleted};
use App\Listeners\{DeleteCupImage, UpdateCoffeeRun};
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CupUpdated::class => [
            DeleteCupImage::class,
        ],
        CupDeleted::class => [
            DeleteCupImage::class,
        ],
        AdhocCoffeeCreated::class => [
            UpdateCoffeeRun::class,
        ]
    ];

    /**
     * Register any events for your application.
     *``
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
