<?php namespace App\Jobs;

use App\Models\App\Inquilino;
use App\Models\Inquilino\Alarma;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AlarmaCreada extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $alarma;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($alarma)
    {
        parent::__construct();
        $this->alarma = $alarma;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        Inquilino::setActivo($this->inquilino->host);
        $data['alarma'] = Alarma::findOrFail($this->alarma);
        $usuarios = $data['alarma']->users;
        $asunto = 'Nueva alarma registrada en ' . $this->inquilino->nombre;

        foreach ($usuarios as $usuario) {
            $data['nombre'] = $usuario->nombre_completo;
            $usuario->enviarCorreo('emails.alarmas.created', $data, $asunto);
        }
    }
}
