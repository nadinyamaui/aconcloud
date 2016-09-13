<?php namespace App\Http\Controllers\Registrar;

use App\Events\CargarPanelesAdicionales;
use App\Helpers\ElFinder;
use App\Helpers\PanelArchivo;
use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use App\Models\Inquilino\MovimientosCuenta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IngresosController extends Controller
{

    use BasicCRUDTrait;

    public function __construct()
    {
        $this->middleware('permisos.junta', ['except' => ['index', 'show']]);
        $this->middleware('inquilino.configurado', ['only' => ['index', 'create']]);
    }

    public function index()
    {
        return redirect('consultas/ingresos');
    }

    public function destroy($id)
    {
        $ingreso = MovimientosCuenta::findOrFail($id);
        if ($ingreso->eliminar()) {
            return response()->json(['mensaje' => 'Se eliminó el ingreso correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar este ingreso, debido a que ya esta procesado'], 400);
    }

    public function show($id)
    {
        $data['ingreso'] = MovimientosCuenta::findOrFail($id);

        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales($data['ingreso'],
            ['archivos', 'comentarios']));

        return view('registrar.ingresos.show', $data);
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $ingreso = MovimientosCuenta::findOrNew($id);
        if (!$ingreso->puedeEditar()) {
            return redirect('consultas/ingresos')->with('error',
                'No se puede editar este ingreso, debido a que ya esta procesado');
        }
        $ingreso->fill($request->all());
        $ingreso->forma_pago = "banco";
        $ingreso->tipo_movimiento = "NC";
        if ($ingreso->validate()) {
            $ingreso->actualizarCrear();

            return redirect('consultas/ingresos')->with('mensaje', 'Se guardó el ingreso correctamente');
        }

        return redirect()->back()->withErrors($ingreso->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['ingreso'] = MovimientosCuenta::findOrNew($id);
        if (is_object($data['ingreso']->movimientoPadre) || $data['ingreso']->ind_movimiento_en_cuotas) {
            return redirect('consultas/ingresos')->with('error',
                'No se pueden editar ingresos que estan fraccionados en cuotas, debe eliminarlos y volverlos a crear');
        }
        $data['clasificaciones'] = ClasificacionIngresoEgreso::getLista(false);
        if (!$data['ingreso']->exists) {
            $data['ingreso']->fecha_factura = Carbon::now();
        }
        if (!$data['ingreso']->puedeEditar()) {
            return redirect('consultas/ingresos')->with('error',
                'No se puede editar este ingreso, debido a que ya esta procesado');
        }

        if ($data['ingreso']->exists) {
            $data['panelesAdicionales'] = event(new CargarPanelesAdicionales($data['ingreso'],
                ['archivos', 'comentarios']));
        }

        return view('registrar.ingresos.form', $data);
    }

}
