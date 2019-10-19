<?php

namespace App\Events;

use App\Models\Cup;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CupUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The cup model
     *
     * @var \App\Models\Cup
     */
    public $cup;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Cup  $cup
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
