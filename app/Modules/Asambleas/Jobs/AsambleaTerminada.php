<?php

namespace App\Modules\Asambleas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Asambleas\Asamblea;

class AsambleaTerminada extends Job implements ShouldQueue
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
        $this->initialize();
        $asamblea = Asamblea::findOrFail($this->asamblea_id);

        $data['id'] = $asamblea->id;
        $data['titulo'] = $asamblea->titulo;
        $data['asunto'] = $data['titulo'].', ha culminado';

        $data['propuestas'] = $asamblea->propuestas;
        $usuarios = Inquilino::$current->usuarios;
        foreach ($usuarios as $usuario) {
            $data['destinatario'] = $usuario->nombre_completo;
            $usuario->enviarCorreo('asambleas::emails.asambleas.terminada', $data, $data['asunto']);
        }
    }
}
