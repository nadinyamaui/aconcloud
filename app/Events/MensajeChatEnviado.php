<?php

namespace App\Events;

use App\Models\App\Inquilino;
use App\Models\Inquilino\MensajeChat;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MensajeChatEnviado extends Event implements ShouldBroadcast
{
    public $mensaje;
    public $inquilino_id;

    public function __construct(MensajeChat $mensaje)
    {
        $this->mensaje = $mensaje->load('autor')->toArray();
        $this->inquilino_id = Inquilino::$current->id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['aconcloud-channel'];
    }
}
