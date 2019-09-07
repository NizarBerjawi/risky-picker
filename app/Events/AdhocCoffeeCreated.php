<?php

namespace App\Events;

use App\Models\{ CoffeeRun, UserCoffee };
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdhocCoffeeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user coffee model
     *
     * @var \App\Models\UserCoffee
     */
    public $userCoffee;

    /**
     * The coffee run
     *
     * @var \App\Models\CoffeeRun
     */
    public $run;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\CoffeeRun  $run
     * @param \App\Models\UserCoffee  $userCoffee
     * @return void
     */
    public function __construct(CoffeeRun $run, UserCoffee $userCoffee)
    {
        $this->userCoffee = $userCoffee;
        $this->run = $run;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
