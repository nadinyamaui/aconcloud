<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\TipoVivienda;
use Illuminate\Http\Request;

class TipoViviendasController extends Controller
{

    use BasicCRUDTrait;

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = TipoVivienda::getDescriptions([
            'nombre',
            'cantidad_apartamentos',
            'porcentaje_pago',
            'total_porcentaje'
        ]);

        return view('admin-inquilino.tipo-viviendas.index', $data);
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
        $tipo = TipoVivienda::findOrFail($id);
        if ($tipo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el Tipo de vivienda correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el Tipo de vivienda, tiene registros asociados']);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, TipoVivienda::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $tipo = TipoVivienda::findOrNew($id);
        $tipo->fill($request->all());
        if ($tipo->save()) {
            return redirect('admin-inquilino/tipo-viviendas')->with('mensaje',
                'Se guardó el Tipo de vivienda correctamente');
        }

        return redirect()->back()->withErrors($tipo->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['tipo'] = TipoVivienda::findOrNew($id);

        return view('admin-inquilino.tipo-viviendas.form', $data);
    }

}
