<?php

namespace App\Modules\Asambleas\Console\Commands;

use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Modules\Asambleas\Asamblea;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnviarNotificacionMatutina extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asambleas:enviar_notificacion_matutina';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia una notificacion a los usuarios indicando que tienen una asamblea primera notificacion que se da en la manana';

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
        foreach ($inquilinos as $inquilino) {
            if ($inquilino->tieneModulo('asambleas')) {
                $this->info('Activando inquilino: '.$inquilino->nombre);
                //Activamos el inquilino
                Inquilino::setActivo($inquilino->host);
                $hoy = Carbon::now();
                $asambleas = Asamblea::whereIndNotificacionManana(false)->whereFecha($hoy->format('Y-m-d'))->whereEstatus("pendiente")->get();
                $usuarios = Inquilino::$current->usuarios;
                foreach ($asambleas as $asamblea) {
                    $this->info('Notificando asamblea: '.$asamblea->titulo);
                    foreach ($usuarios as $usuario) {
                        $data['id'] = $asamblea->id;
                        $data['destinatario'] = $usuario->nombre_completo;
                        $data['titulo'] = $asamblea->titulo;
                        $data['hora_inicio'] = $asamblea->hora_inicio;
                        $data['hora_fin'] = $asamblea->hora_fin;
                        $data['es_autor'] = $usuario->id == $asamblea->autor_id;
                        //Se le envia un mensaje de texto al autor de la propuesta
                        if ($data['es_autor']) {
                            SmsEnviado::encolar('Te informamos que eres el moderador de una asamblea que se dictará el dia de hoy, recuerda tener todo preparado para que la asamblea comience a tiempo', $usuario);
                        }
                        $usuario->enviarCorreo('asambleas::emails.asambleas.notificaciones.matutina', $data, 'Notificación de asamblea en '.$inquilino->nombre);
                    }

                    $asamblea->ind_notificacion_manana = true;
                    $asamblea->save();
                }
            }
        }
    }
}
