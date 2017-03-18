<?php

namespace App\Modules\Mensajeria\Events;

use App\Models\App\User;
use App\Modules\Mensajeria\Mensaje;

class EmailEnviadoHandler
{

    public function enviandoEmail($mensaje)
    {
        $destinos = $mensaje->getTo();
        foreach ($destinos as $destino => $nombre) {
            $usuario = User::findByEmail($destino);
            if (is_object($usuario)) {
                $mensajeInterno = new Mensaje();
                $mensajeInterno->remitente()->associate($usuario);
                $mensajeInterno->destinatario()->associate($usuario);
                $mensajeInterno->asunto = $mensaje->getSubject();
                $mensajeInterno->cuerpo = $mensaje->getBody();
                $mensajeInterno->ind_automatico = true;
                $mensajeInterno->save();
            }
        }
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
        $events->listen('mailer.sending', 'App\Modules\Mensajeria\Events\EmailEnviadoHandler@enviandoEmail');
    }
}
