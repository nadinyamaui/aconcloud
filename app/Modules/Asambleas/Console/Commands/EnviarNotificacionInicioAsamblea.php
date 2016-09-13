<?php

namespace App\Modules\Asambleas\Console\Commands;

use App\Models\App\Inquilino;
use App\Modules\Asambleas\Asamblea;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnviarNotificacionInicioAsamblea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asambleas:enviar_notificacion_inicio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia una notificacion indicandole a los usuarios que la asamblea ha comenzado';

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

                $asambleas = Asamblea::whereIndNotificacionInicio(false)->whereFecha($hoy->format('Y-m-d'))->whereEstatus("pendiente")->get();

                foreach ($asambleas as $asamblea)
                {
                    $fechaInicio = $asamblea->getFechaInicio();

                    //Si la asamblea ya comenzo mandemos los correos
                    if($fechaInicio->lte(Carbon::now()))
                    {
                        $this->info('Notificando asamblea: '.$asamblea->titulo);
                        $usuario = $asamblea->autor;
                        $data['id'] = $asamblea->id;
                        $data['destinatario'] = $usuario->nombre_completo;
                        $data['titulo'] = $asamblea->titulo;
                        $data['hora_inicio'] = $asamblea->hora_inicio;
                        $data['hora_fin'] = $asamblea->hora_fin;
                        $data['esta_retrasada'] = !$asamblea->sePuedeComenzar();

                        $usuario->enviarCorreo('asambleas::emails.asambleas.notificaciones.inicio', $data, 'Notificación de asamblea en '.$inquilino->nombre);

                        $asamblea->ind_notificacion_inicio = true;
                        $asamblea->save();
                    }
                }
            }
        }
    }
}
