<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ComprobanteCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comprobante;
    /**
     * Create a new event instance.
     *
     * @param $comprobante
     */
    public function __construct($comprobante)
    {
        $this->comprobante = $comprobante;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
