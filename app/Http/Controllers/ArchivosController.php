<?php namespace App\Http\Controllers;

use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\Archivo;
use Illuminate\Http\Request;

class ArchivosController extends Controller
{

    use BasicCRUDTrait;

    public function index()
    {
        return view('archivos');
    }

    public function datatable(Request $request, DatatableResponse $handler)
    {
        return $handler->create($request, Archivo::filtrar($request->all()));
    }

    public function destroy($id)
    {
        $archivo = Archivo::findOrFail($id);
        if ($archivo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el archivo correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el archivo, permiso denegado'], 400);
    }

    public function descargar($id)
    {
        $archivo = Archivo::findOrFail($id);

        return response()->download(\Config::get('filesystems.disks.local.root') . '/' . $archivo->ruta);
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $archivo = Archivo::findOrNew($id);
        if ($archivo->exists) {
            $archivo->nombre = $request->get('nombre');
        } else {
            $archivo->fill($request->only('nombre', 'ruta', 'item_id', 'item_type'));
        }
        if ($archivo->save()) {
            return response()->json(['mensaje' => 'Se guardó el archivo correctamente', 'archivo' => $archivo]);
        }

        return response()->json(['errores' => $archivo->getErrors()], 400);
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['archivo'] = Archivo::findOrNew($id);
        $data['archivo']->item_id = $request->get('item_id');
        $data['archivo']->item_type = $request->get('item_type');

        return view('archivos.form', $data);
    }

}
