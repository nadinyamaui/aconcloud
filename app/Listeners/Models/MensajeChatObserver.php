<?php

namespace App\Listeners\Models;

use App\Events\MensajeChatEnviado;

class MensajeChatObserver extends BaseObserver
{

    public function created($mensaje)
    {
        event(new MensajeChatEnviado($mensaje));
    }
}
