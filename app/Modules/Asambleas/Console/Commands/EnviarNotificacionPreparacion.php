<?php

namespace App\Modules\Asambleas\Console\Commands;

use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Modules\Asambleas\Asamblea;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnviarNotificacionPreparacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asambleas:enviar_notificacion_preparacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia una notificacion a los usuarios indicando que la asamblea comenzará en unos 30 minutos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $inquilinos = Inquilino::all();
        foreach($inquilinos as $inquilino)
        {
            if($inquilino->tieneModulo('asambleas'))
            {
                $this->info('Activando inquilino: '.$inquilino->nombre);
                //Activamos el inquilino
                Inquilino::setActivo($inquilino->host);
                $hoy = Carbon::now();

                //Se buscan las asambleas del dia de hoy
                $asambleas = Asamblea::whereIndNotificacionPreparacion(false)->whereFecha($hoy->format('Y-m-d'))->whereEstatus("pendiente")->get();
                $usuarios = Inquilino::$current->usuarios;
                foreach ($asambleas as $asamblea)
                {
                    $fechaInicio = $asamblea->getFechaInicio();

                    //Si la asamblea comienza en 30 minutos o menos enviemos un correo
                    if($fechaInicio->diffInMinutes($hoy, true) <= 30){

                        $this->info('Notificando asamblea: '.$asamblea->titulo);
                        foreach($usuarios as $usuario)
                        {
                            $data['id'] = $asamblea->id;
                            $data['destinatario'] = $usuario->nombre_completo;
                            $data['titulo'] = $asamblea->titulo;
                            $data['hora_inicio'] = $asamblea->hora_inicio;
                            $data['hora_fin'] = $asamblea->hora_fin;
                            $data['es_autor'] = $usuario->id == $asamblea->autor_id;
                            $data['esta_retrasada'] = !$asamblea->sePuedeComenzar();
                            //Se le envia un mensaje de texto al autor de la propuesta
                            if($data['es_autor']){
                                if($asamblea->sePuedeComenzar()){
                                    SmsEnviado::encolar('Eres el moderador de una asamblea que comenzará en 30 minutos, ya todo esta configurado y listo para empezar', $usuario);
                                }else{
                                    SmsEnviado::encolar('Eres el moderador de una asamblea que inicia en 30 minutos. Debes crear el evento en youtube y colocar el link en aconcloud, sin esto la misma no podrá iniciar', $usuario);
                                }
                            }
                            $usuario->enviarCorreo('asambleas::emails.asambleas.notificaciones.preparacion', $data, 'En 30 minutos estaremos en vivo, ve preparandote');
                        }
                        $asamblea->ind_notificacion_preparacion = true;
                        $asamblea->save();
                    }
                }
            }
        }
    }
}
