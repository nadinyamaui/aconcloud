<?php

namespace App\Modules\Asambleas\Listeners\Models;

use App\Listeners\Models\BaseObserver;
use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Models\Inquilino\Vivienda;
use App\Modules\Asambleas\Asamblea;
use App\Modules\Asambleas\Asistente;
use App\Modules\Asambleas\Jobs\AsambleaCreada;
use App\Modules\Propuestas\Jobs\PropuestaCreada;
use App\Modules\Propuestas\Propuesta;
use App\Modules\Propuestas\Votacion;

class AsambleaObserver extends BaseObserver
{
    public function created(Asamblea $asamblea)
    {
        $usuarios = Inquilino::$current->usuarios;

        if ($asamblea->ind_enviar_sms) {
            $mensaje = $asamblea->autor->nombre . ', ha convocado una asamblea ' . $asamblea->titulo;
            foreach ($usuarios as $usuario) {
                SmsEnviado::encolar($mensaje, $usuario);
            }
        }

        //Se buscan los usuarios para llenar la table de asistencias
        $usuarios = Inquilino::$current->usuarios;
        foreach($usuarios as $usuario){
            $asistente = new Asistente();
            $asistente->user()->associate($usuario);
            $asistente->asamblea()->associate($asamblea);
            $asistente->save();
        }
    }

    public function deleting(Asamblea $asamblea)
    {
        if($asamblea->puedeEliminar()){
            $asamblea->mensajesChat()->delete();
            $asamblea->asistentes()->delete();

            $propuestas = $asamblea->propuestas;
            $propuestas->each(function(Propuesta $propuesta){
                $propuesta->estatus = "abierta";
                $propuesta->asamblea_id = null;
                $propuesta->save();
            });
            return true;
        }
        return false;
    }
}