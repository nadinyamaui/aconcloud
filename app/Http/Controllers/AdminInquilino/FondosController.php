<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\MovimientosCuenta;
use Illuminate\Http\Request;

class FondosController extends Controller
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
        $data['columns'] = Fondo::getDescriptions([
            'nombre',
            'saldo_actual',
            'ind_caja_chica',
            'porcentaje_reserva',
            'cuenta->numero',
            'ind_activo'
        ]);

        return view('admin-inquilino.fondos.index', $data);
    }

    public function show($id)
    {
        $data['fondo'] = Fondo::findOrFail($id);
        $data['columns'] = MovimientosCuenta::getDescriptions([
            'clasificacion->nombre',
            'monto_egreso',
            'forma_pago',
            'fecha_factura',
            'estatus_display',
            'comentarios'
        ]);

        return view('admin-inquilino.fondos.show', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $fondo = Fondo::findOrFail($id);
        if ($fondo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el fondo correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el fondo, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Fondo::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $fondo = Fondo::findOrNew($id);
        $fondo->fill($request->all());
        if ($fondo->save()) {
            if ($request->ajax()) {
                return response()->json(['mensaje' => 'Se guardó el fondo correctamente']);
            }

            return redirect('admin-inquilino/fondos')->with('mensaje', 'Se guardó el fondo correctamente');
        }
        if ($request->ajax()) {
            return response()->json(['errores' => $fondo->getErrors()], 400);
        }

        return redirect()->back()->withErrors($fondo->getErrors())->withInput();
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['fondo'] = Fondo::findOrNew($id);
        if ($request->ajax()) {
            return view('admin-inquilino.fondos.modal', $data);
        }

        return view('admin-inquilino.fondos.form', $data);
    }

}
