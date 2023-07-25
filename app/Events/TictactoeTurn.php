<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TictactoeTurn implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $room;
    public $cell;
    public $symbol;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room, $cell, $symbol)
    {
        $this->room = $room;
        $this->cell = $cell;
        $this->symbol = $symbol;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('tictactoe.' . $this->room);
    }

    public function broadcastAs()
    {
        return "select";
    }
}
