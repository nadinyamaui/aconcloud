<?php namespace App\Modules\Mensajeria\Jobs;

use App\Jobs\Job;
use App\Models\App\Inquilino;
use App\Modules\Mensajeria\Mensaje;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MensajeEnviado extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $mensaje_id;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($mensaje_id)
    {
        parent::__construct();
        $this->mensaje_id = $mensaje_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(Mailer $mail)
    {
        Inquilino::setActivo($this->inquilino->host);
        $mensaje = Mensaje::findOrFail($this->mensaje_id);
        $data['id'] = $mensaje->id;
        $data['asunto'] = $mensaje->asunto;
        if ($mensaje->ind_sms) {
            $data['cuerpo'] = $mensaje->cuerpo_sms;
        } else {
            $data['cuerpo'] = $mensaje->cuerpo;
        }
        $data['email'] = $mensaje->destinatario->email;
        $data['nombre'] = $mensaje->destinatario->nombre_completo;
        $data['nombreRemitente'] = $mensaje->remitente->nombre_completo;
        $mensaje->destinatario->enviarCorreo('mensajeria::emails.mensajes.enviado', $data, $data['asunto']);
    }

}
