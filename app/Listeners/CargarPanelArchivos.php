<?php

namespace App\Listeners;

use App\Events\CargarPanelesAdicionales;

class CargarPanelArchivos
{
    public function handle(CargarPanelesAdicionales $event)
    {
        if (in_array('archivos', $event->paneles)) {
            if (is_object($event->item)) {
                $data['item_id'] = $event->item->id;
                $data['item_type'] = get_class($event->item);
            } else {
                $data['item_id'] = 0;
                $data['item_type'] = 'global';
            }
            $data['cols'] = count($event->paneles) > 1 ? 6 : 12;
            $dataHTML['html'] = view('archivos.panel', $data)->render();
            $dataHTML['id'] = 'archivos';

            return $dataHTML;
        }
    }
}