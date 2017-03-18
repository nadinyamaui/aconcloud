<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

class FondoObserver extends BaseObserver
{

    public function created($model)
    {
        if ($model->ind_caja_chica == 0) {
            $cuenta = $model->cuenta;
            $cuenta->saldo_actual -= $model->saldo_actual;
            $cuenta->save();
        }
    }

    public function deleted($model)
    {
        $cuenta = $model->cuenta;
        $cuenta->saldo_actual += $model->saldo_actual;
        $cuenta->save();
    }
}
