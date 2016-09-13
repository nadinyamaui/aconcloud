<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Modulo;
use Illuminate\Http\Request;

class ModulosController extends Controller
{

    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = Modulo::getDescriptions(['codigo', 'nombre', 'descripcion', 'costo_mensual']);

        return view('admin.modulos.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $Modulo = Modulo::findOrFail($id);
        if ($Modulo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el módulo correctamente']);
        }

        return response()->json(['mensaje' => 'No se puede eliminar el módulo, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Modulo::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $Modulo = Modulo::findOrNew($id);
        $Modulo->fill($request->all());
        if ($Modulo->save()) {
            return redirect('admin/modulos')->with('mensaje', 'Se guardó el módulo correctamente');
        }

        return redirect()->back()->withErrors($Modulo->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['modulo'] = Modulo::findOrNew($id);

        return view('admin.modulos.form', $data);
    }

}
