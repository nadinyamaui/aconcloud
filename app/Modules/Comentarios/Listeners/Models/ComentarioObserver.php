<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Modules\Comentarios\Listeners\Models;

use App\Listeners\Models\BaseObserver;
use App\Modules\Comentarios\Comentario;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\Auth;

class ComentarioObserver extends BaseObserver
{

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct($dispatcher);
    }

    public function saving($model)
    {
        if (!$model->exists) {
            $model->autor_id = Auth::id();
        }

        return parent::saving($model);
    }

    public function deleting(Comentario $comentario)
    {
        return $comentario->puedeEliminar();
    }
}