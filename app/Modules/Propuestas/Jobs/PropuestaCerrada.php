<?php namespace App\Modules\Propuestas\Jobs;

use App\Jobs\Job;
use App\Modules\Propuestas\Propuesta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PropuestaCerrada extends Job implements ShouldQueue
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
        $this->initialize();
        $propuesta = Propuesta::findOrFail($this->propuesta_id);

        $data['id'] = $propuesta->id;
        $data['titulo'] = $propuesta->titulo;
        $data['decision'] = $propuesta->decision_display;
        $data['total_votantes'] = $propuesta->total_votantes;
        $data['total_votantes_pendientes'] = $propuesta->total_votantes_pendientes;
        $data['total_votos_a_favor'] = $propuesta->total_votos_a_favor;
        $data['total_votos_en_contra'] = $propuesta->total_votos_en_contra;

        $users = $this->inquilino->usuarios;
        foreach ($users as $user) {
            $data['destinatario'] = $user->nombre_completo;
            $data['asunto'] = "Proceso de votación finalizado";

            $user->enviarCorreo('propuestas::emails.propuestas.cerrada', $data, $data['asunto']);
        }
    }
}
