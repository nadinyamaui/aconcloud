<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Models\Inquilino\CorteRecibo;

class CorteReciboObserver extends BaseObserver
{

    public function creating(CorteRecibo $corteRecibo)
    {
        $count = CorteRecibo::whereEstatus("ELA")->count();
        if ($count > 0) {
            $corteRecibo->addError("estatus",
                "Existe un corte en elaboración, se debe procesar antes de generar un nuevo corte");
        }

        return !$corteRecibo->hasErrors();
    }

    public function deleting($model)
    {
        return $model->estatus == "ELA";
    }
}