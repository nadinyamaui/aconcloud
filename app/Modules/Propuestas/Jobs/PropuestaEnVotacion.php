<?php namespace App\Modules\Propuestas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Modules\Propuestas\Propuesta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PropuestaEnVotacion extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $propuesta_id;
    protected $activador_votacion_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($propuesta_id, $activador_votacion_id)
    {
        parent::__construct();
        $this->propuesta_id = $propuesta_id;
        $this->activador_votacion_id = $activador_votacion_id;
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
        $data['activador'] = User::findOrFail($this->activador_votacion_id)->nombre_completo;

        $users = $this->inquilino->usuarios;
        foreach ($users as $user) {
            $data['destinatario'] = $user->nombre_completo;
            $data['asunto'] = "Propuesta (" . $propuesta->titulo . ") en proceso de votación";

            $user->enviarCorreo('propuestas::emails.propuestas.en_votacion', $data, $data['asunto']);
        }
    }
}
