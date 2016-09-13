<?php namespace App\Http\Controllers\Registrar;

use App\Events\CargarPanelesAdicionales;
use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\MovimientosCuenta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GastosController extends Controller
{
    use BasicCRUDTrait;

    public function __construct()
    {
        $this->middleware('permisos.junta', ['except' => ['index', 'show']]);
        $this->middleware('inquilino.configurado', ['only' => ['index', 'create']]);
    }

    public function index()
    {
        return redirect('consultas/gastos');
    }

    public function destroy($id)
    {
        $gasto = MovimientosCuenta::findOrFail($id);
        if ($gasto->eliminar()) {
            return response()->json(['mensaje' => 'Se eliminó el gasto correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar este gasto, debido a que ya esta procesado'], 400);
    }

    public function show($id)
    {
        $data['gasto'] = MovimientosCuenta::findOrFail($id);
        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales($data['gasto'], ['archivos', 'comentarios']));

        return view('registrar.gastos.show', $data);
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $gasto = MovimientosCuenta::findOrNew($id);
        if (!$gasto->puedeEditar()) {
            return redirect('consultas/gastos')->with('error',
                'No se puede editar este gasto, debido a que ya esta procesado');
        }
        $gasto->fill($request->all());
        if ($gasto->forma_pago == "efectivo") {
            $gasto->fondo_id = Fondo::buscarCajaChica()->id;
        }
        $gasto->tipo_movimiento = "ND";
        if ($gasto->validate()) {
            $gasto->actualizarCrear();
            $gasto->asociarViviendas($request->get('viviendas', []));

            return redirect('consultas/gastos')->with('mensaje', 'Se guardó el gasto correctamente');
        }

        return redirect()->back()->withErrors($gasto->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['gasto'] = MovimientosCuenta::findOrNew($id);
        if (is_object($data['gasto']->movimientoPadre) || $data['gasto']->ind_movimiento_en_cuotas) {
            return redirect('consultas/gastos')->with('error',
                'No se pueden editar gastos que estan fraccionados en cuotas, debe eliminarlos y volverlos a crear');
        }
        if (is_object($data['gasto']->movimientoPadre)) {
            return redirect('registrar/gastos/' . $data['gasto']->movimiento_cuenta_cuota_id . '/edit');
        }
        if (!$data['gasto']->exists) {
            $data['gasto']->fecha_factura = Carbon::now();
        }
        $data['clasificaciones'] = ClasificacionIngresoEgreso::getLista(true);
        if (!$data['gasto']->puedeEditar()) {
            return redirect('consultas/gastos')->with('error',
                'No se puede editar este gasto, debido a que ya esta procesado o esta bloqueado');
        }
        if ($data['gasto']->exists) {
            $data['panelesAdicionales'] = event(new CargarPanelesAdicionales($data['gasto'],
                ['archivos', 'comentarios']));
        }

        return view('registrar.gastos.form', $data);
    }

}
