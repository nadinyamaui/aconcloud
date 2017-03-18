<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Jobs\GastoModificado;
use App\Jobs\GastoRegistrado;
use App\Jobs\IngresoModificado;
use App\Jobs\IngresoRegistrado;
use App\Models\Inquilino\MovimientosCuenta;
use Auth;

class MovimientoCuentaObserver extends BaseObserver
{

    public function created(MovimientosCuenta $model)
    {
        $user = Auth::user();
        $interno = true;
        if (is_object($model->clasificacion)) {
            $interno = in_array($model->clasificacion->codigo, ['pago.recibos']);
        }
        if (!$interno && is_null($model->movimiento_cuenta_cuota_id) && $user != null) {
            if ($model->monto_ingreso == null) {
                $this->dispatcher->dispatch(new GastoRegistrado($model->id, $user));
            } else {
                if ($model->monto_egreso == null && $model->ind_afecta_calculos !== false) {
                    $this->dispatcher->dispatch(new IngresoRegistrado($model->id, $user));
                }
            }
        }
    }

    public function updated(MovimientosCuenta $model)
    {
        $user = Auth::user();
        if ($model->isDirty('estatus')) {
            return;
        }
        $interno = true;
        if (is_object($model->clasificacion)) {
            $interno = in_array($model->clasificacion->codigo, ['pago.recibos']);
        }
        if (!$interno && is_null($model->movimiento_cuenta_cuota_id) && $user != null) {
            if ($model->monto_ingreso == null) {
                $this->dispatcher->dispatch(new GastoModificado($model->id, $user));
            } else {
                if ($model->monto_egreso == null && $model->ind_afecta_calculos !== false) {
                    $this->dispatcher->dispatch(new IngresoModificado($model->id, $user));
                }
            }
        }
    }

    public function saving($model)
    {
        if (parent::saving($model)) {
            $model->ind_gasto_no_comun = $model->viviendas()->count() > 0;
            $fondo = $model->fondo;
            if (!is_null($fondo) && $fondo->ind_caja_chica) {
                $model->ind_afecta_calculos = false;
            }
        }

        return !$model->hasErrors();
    }

    public function saved($model)
    {
        if ($model->forma_pago != "" && $model->isDirty('monto_egreso') && $model->fecha_pago == null) {
            $fondo = $model->fondo;
            $cuenta = $model->cuenta;
            $montoAnterior = $model->getOriginal('monto_egreso');
            if (is_object($fondo)) {
                $fondo->saldo_actual -= $model->monto_egreso;
                $fondo->saldo_actual += $montoAnterior;
                $fondo->save();
            } else {
                if (is_object($cuenta)) {
                    $cuenta->saldo_actual -= $model->monto_egreso;
                    $cuenta->saldo_actual += $montoAnterior;
                    $cuenta->save();
                }
            }
        } else {
            if ($model->isDirty('monto_ingreso') && $model->fecha_pago == null) {
                $cuenta = $model->cuenta;
                $montoAnterior = $model->getOriginal('monto_ingreso');
                $cuenta->saldo_actual += $model->monto_ingreso;
                $cuenta->saldo_actual -= $montoAnterior;
                $cuenta->save();
            }
        }
    }

    public function deleting(MovimientosCuenta $model)
    {
        if ($model->estatus == "PEN") {
            $model->viviendas()->detach();
            $model->movimientoCuotas->each(function ($mov) {
                $mov->delete();
            });
            $model->alarmas->each(function ($alarma) {
                $alarma->delete();
            });

            return true;
        }

        return false;
    }

    public function deleted($model)
    {
        $fondo = $model->fondo;
        $cuenta = $model->cuenta;

        if (is_object($fondo)) {
            $fondo->saldo_actual += $model->monto_egreso;
            $fondo->save();
        } else {
            if (is_object($cuenta)) {
                $cuenta->saldo_actual += $model->monto_egreso;
                $cuenta->saldo_actual -= $model->monto_ingreso;
                $cuenta->save();
            }
        }
    }
}
