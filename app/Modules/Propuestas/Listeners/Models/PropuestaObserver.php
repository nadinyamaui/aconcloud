<?php

namespace App\Modules\Propuestas\Listeners\Models;

use App\Listeners\Models\BaseObserver;
use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Models\Inquilino\Vivienda;
use App\Modules\Propuestas\Jobs\PropuestaCreada;
use App\Modules\Propuestas\Propuesta;
use App\Modules\Propuestas\Votacion;

class PropuestaObserver extends BaseObserver
{
    public function created(Propuesta $propuesta)
    {
        $usuarios = Inquilino::$current->usuarios;
        if ($propuesta->ind_enviar_email) {
            $this->dispatcher->dispatch(new PropuestaCreada($propuesta->id));
        }

        if ($propuesta->ind_enviar_sms) {
            $mensaje = $propuesta->autor->nombre . ', ha hecho una propuesta sobre ' . $propuesta->titulo;
            foreach ($usuarios as $usuario) {
                SmsEnviado::encolar($mensaje, $usuario);
            }
        }

        $viviendas = Vivienda::all();
        $viviendas->each(function (Vivienda $vivienda) use ($propuesta) {
            $votacion = new Votacion();
            $votacion->vivienda()->associate($vivienda);
            $votacion->propuesta()->associate($propuesta);
            $votacion->save();
        });
    }

    public function deleting($propuesta)
    {
        $propuesta->autorizados()->detach();
        $propuesta->comentarios->each(function ($comentario) {
            $comentario->delete();
        });
        $propuesta->archivos->each(function ($archivo) {
            $archivo->delete();
        });
        $propuesta->mensajesChat()->delete();

        $propuesta->votaciones->each(function ($votacion) {
            $votacion->delete();
        });
        return true;
    }
}
