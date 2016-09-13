<?php namespace App\Http\Controllers\Miscelaneos;

use App\Events\CargarPanelesAdicionales;
use App\Helpers\PanelArchivo;
use App\Http\Controllers\Controller;

class ArchivosController extends Controller
{

    public function index()
    {
        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales(null, ['archivos']));

        return view('miscelaneos.archivos.index', $data);
    }

}
