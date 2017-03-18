<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\TipoAyuda;
use Illuminate\Http\Request;

class TipoAyudasController extends Controller
{

    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = TipoAyuda::getDescriptions(['nombre']);

        return view('admin.tipo-ayudas.index', $data);
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
        $tipo = TipoAyuda::findOrFail($id);
        if ($tipo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el tipo de ayuda correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el tipo de ayuda, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, TipoAyuda::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $tipo = TipoAyuda::findOrNew($id);
        $tipo->fill($request->all());
        if ($tipo->save()) {
            return redirect('admin/tipo-ayudas')->with('mensaje', 'Se guardó la ayuda correctamente');
        }

        return redirect()->back()->withErrors($tipo->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['tipo'] = TipoAyuda::findOrNew($id);

        return view('admin.tipo-ayudas.form', $data);
    }
}
