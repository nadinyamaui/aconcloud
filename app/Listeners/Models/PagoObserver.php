<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Models\Inquilino\Pago;
use App\Models\Inquilino\Recibo;

class PagoObserver extends BaseObserver
{

    public function updating(Pago $model)
    {
        return !$model->hasErrors();
    }

    public function deleting(Pago $model)
    {
        if ($model->puedeEliminar()) {
            $model->recibos->each(function (Recibo $recibo) {
                $recibo->estatus = "GEN";
                $recibo->save();
            });
            $model->recibos()->detach();

            return true;
        }

        return false;
    }

    public function deleted(Pago $model)
    {
        $model->movimientoCuenta->delete();
    }
}
