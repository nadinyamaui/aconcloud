<?php namespace App\Jobs;

use App\Helpers\Helper;
use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Models\Inquilino\Recibo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReciboVencido extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $recibo;
    protected $vivienda;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($recibo)
    {
        parent::__construct();
        $this->recibo = $recibo;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        Inquilino::setActivo($this->inquilino->host);
        $this->recibo = Recibo::findOrFail($this->recibo);
        $this->vivienda = $this->recibo->vivienda;
        $this->generarEmail($mailer);
        $this->generarSMS();
    }

    private function generarEmail(Mailer $mailer)
    {
        $usuarios = $this->vivienda->listaUsuarios();
        $nombreInquilino = $this->inquilino->nombre;
        foreach ($usuarios as $usuario) {
            $data['nombre'] = $usuario->nombre;
            $data['recibo'] = $this->recibo;
            $data['inquilino'] = $this->inquilino;

            $usuario->enviarCorreo('emails.recibos.vencido', $data, 'Revisa tu estado de cuenta presentas una deuda vencida en ' . $nombreInquilino);
        }
    }

    private function generarSMS()
    {
        $usuarios = $this->vivienda->listaUsuarios();
        foreach ($usuarios as $usuario) {
            $mensaje = "Aconcloud te informa que presentas una deuda vencida de Bs. " . Helper::tm($this->vivienda->saldo_deudor) . ". Para visualizar el detalle ingresa en http://" . $this->inquilino->host;
            SmsEnviado::encolar($mensaje, $usuario);
        }
    }
}
