<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Models\Inquilino\Archivo;
use Illuminate\Support\Facades\Storage;

class ArchivoObserver extends BaseObserver
{

    public function deleting(Archivo $model)
    {
        return $model->puedeEliminar();
    }

    public function deleted(Archivo $model)
    {
        if (Storage::exists($model->ruta)) {
            Storage::delete($model->ruta);
        }
    }
}
