<?php

namespace Picker\Cup\Events;

use Picker\Cup\Cup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CupUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The cup model
     *
     * @var Cup
     */
    public $cup;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Cup $cup)
    {
        $this->cup = $cup;
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
