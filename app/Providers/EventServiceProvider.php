<?php

namespace App\Providers;

use Picker\CoffeeRun\Events\AdhocCoffeeCreated;
use Picker\CoffeeRun\Listeners\UpdateCoffeeRun;
use Picker\Cup\Events\CupUpdated;
use Picker\Cup\Events\CupDeleted;
use Picker\Cup\Listeners\DeleteCupImage;
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
