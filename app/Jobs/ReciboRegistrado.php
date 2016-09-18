<?php

namespace App\Jobs;

use App\Helpers\Helper;
use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Models\Inquilino\Recibo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReciboRegistrado extends Job implements ShouldQueue
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

    private function generarEmail()
    {
        $usuarios = $this->vivienda->listaUsuarios();
        $nombreInquilino = $this->inquilino->nombre;
        $data['nombreInquilino'] = $nombreInquilino;
        $data['inquilino'] = $this->inquilino;
        foreach ($usuarios as $usuario) {
            $data['nombre'] = $usuario->nombre;
            $data['recibo'] = $this->recibo;
            $mes = trans('meses.' . $this->recibo->corteRecibo->mes);
            $data['mes'] = $mes;

            $usuario->enviarCorreo('emails.recibos.created', $data, 'Revisa tu notificación de cobro del mes de ' . $mes . ' en digital de ' . $nombreInquilino);
        }
    }

    private function generarSMS()
    {
        $usuarios = $this->vivienda->listaUsuarios();
        foreach ($usuarios as $usuario) {
            $mensaje = "Aconcloud te informa que tu recibo de " . trans('meses.' . $this->recibo->corteRecibo->mes);
            $mensaje .= " número " . $this->recibo->num_recibo . " es de Bs. " . Helper::tm($this->recibo->monto_total);
            $mensaje .= " y vence el " . $this->recibo->corteRecibo->fecha_vencimiento->format("d/m/Y");

            if ($this->vivienda->saldo_deudor > 0) {
                $mensaje .= ". Tienes una deuda vencida de Bs. " . Helper::tm($this->vivienda->saldo_deudor);
            }

            SmsEnviado::encolar($mensaje, $usuario);
        }
    }

}
