<?php namespace App\Modules\Propuestas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use App\Modules\Propuestas\Propuesta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PropuestaCreada extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $propuesta_id;

    public function __construct($propuesta_id)
    {
        parent::__construct();
        $this->propuesta_id = $propuesta_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        Inquilino::setActivo($this->inquilino->host);
        $propuesta = Propuesta::findOrFail($this->propuesta_id);

        $data['id'] = $propuesta->id;
        $data['titulo'] = $propuesta->titulo;
        $data['fecha_cierre'] = $propuesta->fecha_cierre;

        $data['proponente'] = $propuesta->autor->nombre_completo;
        $data['asunto'] = "Nueva propuesta en aconcloud";

        $usuarios = Inquilino::$current->usuarios;
        foreach($usuarios as $user)
        {
            $data['destinatario'] = $user->nombre_completo;
            $user->enviarCorreo('propuestas::emails.propuestas.creada', $data, $data['asunto']);
        }
    }

}
