<?php namespace App\Modules\Propuestas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use App\Modules\Propuestas\Propuesta;
use App\Modules\Propuestas\Votacion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VotoRegistrado extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $propuesta_id;
    protected $voto_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($propuesta_id, $voto_id)
    {
        parent::__construct();
        $this->propuesta_id = $propuesta_id;
        $this->voto_id = $voto_id;
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
        $data['voto'] = Votacion::findOrFail($this->voto_id);
        $user = $data['voto']->user;

        $data['id'] = $propuesta->id;
        $data['email'] = $user->email;
        $data['destinatario'] = $user->nombre_completo;
        $data['asunto'] = "Gracias por ejercer tu derecho al voto!";

        $user->enviarCorreo('propuestas::emails.votaciones.voto', $data, $data['asunto']);
    }

}
