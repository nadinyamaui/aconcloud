<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use Illuminate\Http\Request;

class ClasificacionIngresoEgresoController extends Controller
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
        $data['columns'] = ClasificacionIngresoEgreso::getDescriptions([
            'nombre',
            'dia_estimado',
            'ind_fijo',
            'monto',
            'ind_egreso'
        ]);

        return view('admin-inquilino.clasificacion-ingreso-egreso.index', $data);
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
        $clasificacion = ClasificacionIngresoEgreso::findOrFail($id);
        if ($clasificacion->delete()) {
            return response()->json(['mensaje' => 'Se eliminó la clasificación de ingreso, egreso correctamente']);
        }

        return response()->json(
            ['error' => 'No se puede eliminar la clasificación de ingreso, egreso, tiene registros asociados o esta bloqueado por el administrador'],
            400
        );
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, ClasificacionIngresoEgreso::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $clasificacion = ClasificacionIngresoEgreso::findOrNew($id);
        if (!$clasificacion->puedeEditar()) {
            if ($request->ajax()) {
                return response()->json(['errores' => 'No se puede editar esta clasificación']);
            }

            return redirect('admin-inquilino/clasificacion-ingreso-egreso')->with(
                'error',
                'No se puede editar esta clasificación'
            );
        }
        $clasificacion->fill($request->all());
        if ($clasificacion->save()) {
            if ($request->ajax()) {
                return response()->json(['mensaje' => 'Se guardó la clasificación de ingreso, egreso correctamente']);
            }

            return redirect('admin-inquilino/clasificacion-ingreso-egreso')->with(
                'mensaje',
                'Se guardó la clasificación de ingreso, egreso correctamente'
            );
        }
        if ($request->ajax()) {
            return response()->json(['errores' => $clasificacion->getErrors()], 400);
        }

        return redirect()->back()->withErrors($clasificacion->getErrors())->withInput();
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['clasificacion'] = ClasificacionIngresoEgreso::findOrNew($id);
        if (!$data['clasificacion']->puedeEditar()) {
            if ($request->ajax()) {
                return response()->json(['errores' => 'No se puede editar esta clasificación']);
            }

            return redirect('admin-inquilino/clasificacion-ingreso-egreso')->with(
                'error',
                'No se puede editar esta clasificación'
            );
        }
        if ($request->ajax()) {
            return view('admin-inquilino.clasificacion-ingreso-egreso.modal', $data);
        }

        return view('admin-inquilino.clasificacion-ingreso-egreso.form', $data);
    }
}
