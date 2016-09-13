<?php namespace App\Modules\Propuestas\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Models\App\User;
use App\Models\Inquilino\Vivienda;
use App\Modules\Propuestas\Propuesta;
use App\Modules\Propuestas\Votacion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordarVotoVecinos extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $propuesta_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
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

        $votacionesPendientes = Votacion::wherePropuestaId($propuesta->id)->whereIndCerrado(false)->select('vivienda_id')->get();
        $viviendas = Vivienda::findMany($votacionesPendientes->lists('vivienda_id')->all());
        $users = User::findMany($viviendas->lists('propietario_id')->all());
        foreach ($users as $user) {
            $data['destinatario'] = $user->nombre_completo;
            $data['asunto'] = "Estamos esperando tu voto por la propuesta, ".$propuesta->titulo;

            $user->enviarCorreo('propuestas::emails.votaciones.esperando_voto', $data, $data['asunto']);

            $sms = "Aun no has votado por la propuesta: ".$propuesta->titulo.', recuerda que tu opinion es muy importante para tu comunidad';
            SmsEnviado::encolar($sms, $user);
        }
    }

}
