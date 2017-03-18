<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\MovimientosCuenta;
use Illuminate\Http\Request;

class CuentasController extends Controller
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
        $data['columns'] = Cuenta::getDescriptions([
            'banco->nombre',
            'numero',
            'saldo_actual',
            'saldo_con_fondos',
            'ind_activa'
        ]);

        return view('admin-inquilino.cuentas.index', $data);
    }

    public function show($id)
    {
        $data['cuenta'] = Cuenta::findOrFail($id);
        $data['columns'] = MovimientosCuenta::getDescriptions([
            'referencia',
            'fecha_pago',
            'tipo_movimiento',
            'descripcion',
            'monto_ingreso',
            'monto_egreso',
            'estatus_display'
        ]);

        return view('admin-inquilino.cuentas.show', $data);
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
        $cuenta = Cuenta::findOrFail($id);
        if ($cuenta->delete()) {
            return response()->json(['mensaje' => 'Se eliminó la cuenta correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar la cuenta, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Cuenta::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $cuenta = Cuenta::findOrNew($id);
        $cuenta->fill($request->all());
        if ($cuenta->save()) {
            if ($request->ajax()) {
                return response()->json(['mensaje' => 'Se guardó la cuenta correctamente']);
            }

            return redirect('admin-inquilino/cuentas')->with('mensaje', 'Se guardó la cuenta correctamente');
        }
        if ($request->ajax()) {
            return response()->json(['errores' => $cuenta->getErrors()], 400);
        }

        return redirect()->back()->withErrors($cuenta->getErrors())->withInput();
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['cuenta'] = Cuenta::findOrNew($id);
        if ($request->ajax()) {
            return view('admin-inquilino.cuentas.modal', $data);
        }

        return view('admin-inquilino.cuentas.form', $data);
    }
}
