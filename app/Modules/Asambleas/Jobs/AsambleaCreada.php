<?php

namespace App\Modules\Asambleas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Asambleas\Asamblea;

class AsambleaCreada extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $asamblea_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($asamblea_id)
    {
        parent::__construct();
        $this->asamblea_id = $asamblea_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        Inquilino::setActivo($this->inquilino->host);
        $asamblea = Asamblea::findOrFail($this->asamblea_id);

        $data['id'] = $asamblea->id;
        $data['titulo'] = $asamblea->titulo;
        $data['fecha'] = $asamblea->fecha;
        $data['hora_inicio'] = $asamblea->hora_inicio;
        $data['hora_fin'] = $asamblea->hora_fin;

        $data['convocador'] = $asamblea->autor->nombre_completo;
        $data['asunto'] = "Nueva asamblea en ".$this->inquilino->nombre;
        $data['propuestas'] = $asamblea->propuestas;
        $usuarios = Inquilino::$current->usuarios;
        foreach ($usuarios as $usuario) {
            $data['destinatario'] = $usuario->nombre_completo;
            $usuario->enviarCorreo('asambleas::emails.asambleas.creada', $data, $data['asunto']);
        }
    }
}
