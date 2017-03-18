<?php

namespace App\Modules\Comentarios\Listeners;

use App\Events\CargarPanelesAdicionales;
use App\Modules\Comentarios\Comentario;

class CargarPanelComentarios
{
    public function handle(CargarPanelesAdicionales $event)
    {
        if (in_array('comentarios', $event->paneles)) {
            $comentarios = $event->item->comentarios()->get();
            $comentarioNuevo = new Comentario();
            $comentarioNuevo->item_type = get_class($event->item);
            $comentarioNuevo->item_id = $event->item->id;
            $cols = count($event->paneles) > 1 ? 6 : 12;
            $dataHTML['html'] = view('comentarios::panel', compact('comentarios', 'comentarioNuevo', 'cols'))->render();
            $dataHTML['id'] = 'comentarios';

            return $dataHTML;
        }
    }
}
