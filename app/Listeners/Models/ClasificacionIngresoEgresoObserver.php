<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

class ClasificacionIngresoEgresoObserver extends BaseObserver
{

    public function deleting($model)
    {
        return !$model->ind_bloqueado;
    }
}
