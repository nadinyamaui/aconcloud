<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Models\App\TipoAyuda;

class TipoAyudaObserver extends BaseObserver
{

    public function deleting(TipoAyuda $model)
    {
        return $model->ayudas()->count() == 0;
    }
}