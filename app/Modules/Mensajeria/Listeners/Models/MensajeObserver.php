<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Modules\Mensajeria\Listeners\Models;

use App\Listeners\Models\BaseObserver;
use App\Models\App\SmsEnviado;
use App\Modules\Mensajeria\Jobs\MensajeEnviado;
use App\Modules\Mensajeria\Mensaje;
use Bus;

class MensajeObserver extends BaseObserver
{

    public function __construct()
    {
        parent::__construct();
    }

    public function created(Mensaje $mensaje)
    {
        if (!$mensaje->ind_automatico && $mensaje->ind_saliente == false) {
            Bus::dispatch(new MensajeEnviado($mensaje->id));
        }
        if ($mensaje->ind_saliente == false) {
            $copia = new Mensaje($mensaje->toArray());
            $copia->ind_saliente = true;
            $copia->save();
        }
        if ($mensaje->ind_sms && $mensaje->ind_saliente == false) {
            SmsEnviado::encolar($mensaje->cuerpo_sms, $mensaje->destinatario);
        }
    }
}
