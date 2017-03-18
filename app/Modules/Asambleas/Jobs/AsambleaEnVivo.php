<?php

namespace App\Modules\Asambleas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use App\Models\App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Asambleas\Asamblea;

class AsambleaEnVivo extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $asamblea_id;

    public function __construct($asamblea_id)
    {
        parent::__construct();
        $this->asamblea_id = $asamblea_id;
    }

    public function handle()
    {
        Inquilino::setActivo($this->inquilino->host);
        $asamblea = Asamblea::findOrFail($this->asamblea_id);

        $data['id'] = $asamblea->id;
        $data['titulo'] = $asamblea->titulo;

        $usuarios = Inquilino::$current->usuarios;
        foreach ($usuarios as $usuario) {
            $data['destinatario'] = $usuario->nombre_completo;

            $usuario->enviarCorreo('asambleas::emails.asambleas.en_vivo', $data, "3, 2, 1... ¡Estamos en vivo!");
        }
    }
}
