<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Jobs\ReciboRegistrado;
use App\Models\Inquilino\Recibo;

class ReciboObserver extends BaseObserver
{

    public function created(Recibo $model)
    {
        $vivienda = $model->vivienda;
        if ($vivienda->saldo_actual < 0 && abs($vivienda->saldo_actual) > $model->monto_total) {
            $model->pagadoAutomatico();
        }
        $vivienda->saldo_actual += $model->monto_total;
        $vivienda->save();
        $this->dispatcher->dispatch(new ReciboRegistrado($model->id));
    }
}
