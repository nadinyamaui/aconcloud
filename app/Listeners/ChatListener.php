<?php

namespace App\Listeners;

use App\Models\Inquilino\Archivo;
use App\Models\Inquilino\MensajeChat;
use App\Modules\Comentarios\Comentario;

class ChatListener
{
    public function onComentarioAgregado(Comentario $comentario)
    {
        $mensajeChat = new MensajeChat();
        $mensajeChat->message = "He hecho un nuevo comentario: " . $comentario->comentario;
        $mensajeChat->item_id = $comentario->item_id;
        $mensajeChat->item_type = $comentario->item_type;
        $mensajeChat->save();
    }

    public function onArchivoCargado(Archivo $archivo)
    {
        $mensajeChat = new MensajeChat();
        $mensajeChat->message = "He cargado un nuevo archivo: " . $archivo->nombre . ', descargalo aqui ' . $archivo->link_descarga;
        $mensajeChat->item_id = $archivo->item_id;
        $mensajeChat->item_type = $archivo->item_type;
        $mensajeChat->save();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     *
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            'eloquent.created: ' . Comentario::class,
            static::class . '@onComentarioAgregado'
        );

        $events->listen(
            'eloquent.created: ' . Archivo::class,
            static::class . '@onArchivoCargado'
        );
    }

}