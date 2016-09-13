<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Inquilino;
use App\Models\Inquilino\Vivienda;
use Illuminate\Http\Request;

class ViviendasController extends Controller
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
        $data['columns'] = Vivienda::getDescriptions([
            'tipoVivienda->nombre',
            'numero_apartamento',
            'piso',
            'torre',
            'saldo_deudor',
            'saldo_a_favor'
        ]);

        return view('admin-inquilino.viviendas.index', $data);
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
        $vivienda = Vivienda::findOrFail($id);
        if ($vivienda->delete()) {
            return response()->json(['mensaje' => 'Se eliminó la vivienda correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar la vivienda, tiene registros asociados']);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Vivienda::query());
    }

    public function show($id)
    {
        return response()->json(Vivienda::findOrFail($id));
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $vivienda = Vivienda::findOrNew($id);
        $vivienda->fill($request->all());
        if ($vivienda->save()) {
            $vivienda->usuarios()->sync($request->get('usuarios', []));
            if ($request->ajax()) {
                return response()->json(['mensaje' => 'Se guardó la vivienda correctamente']);
            }

            return redirect('admin-inquilino/viviendas')->with('mensaje', 'Se guardó la vivienda correctamente');
        }
        if ($request->ajax()) {
            return response()->json(['errores' => $vivienda->getErrors()], 400);
        }

        return redirect()->back()->withErrors($vivienda->getErrors())->withInput();
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['vivienda'] = Vivienda::findOrNew($id);
        $data['usuarios'] = Inquilino::$current->usuarios->lists('nombre_completo', 'id')->all();
        $data['usuarios'][''] = 'Seleccione';
        if ($request->ajax()) {
            return view('admin-inquilino.viviendas.modal', $data);
        }

        return view('admin-inquilino.viviendas.form', $data);
    }

}
