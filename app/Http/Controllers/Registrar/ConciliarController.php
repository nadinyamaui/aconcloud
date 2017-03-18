<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25-03-2015
 * Time: 07:24 AM
 */

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Inquilino\MovimientosCuenta;
use Illuminate\Http\Request;

class ConciliarController extends Controller
{

    public function __construct()
    {
        $this->middleware('permisos.junta');
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    public function index()
    {
        $data['columnasIngresoEgreso'] = ['referencia', 'tipo_movimiento', 'monto', 'comentarios'];
        $data['ingresosEgresos'] = MovimientosCuenta::pendiente()->whereNotNull('clasificacion_id')->banco()->get();
        $data['columnasEstadoCuenta'] = ['referencia', 'tipo_movimiento', 'monto', 'descripcion'];
        $data['estados'] = MovimientosCuenta::pendiente()->whereNull('clasificacion_id')->banco()->get();

        return view('registrar.conciliar.index', $data);
    }

    public function confirmar($ingreso_id, $estado_id)
    {
        $data['ingreso'] = MovimientosCuenta::findOrFail($ingreso_id);
        $data['estado'] = MovimientosCuenta::findOrFail($estado_id);
        $data['ingreso']->puedeConciliar($data['estado']);
        $data['errors'] = $data['ingreso']->getErrors();

        return view('registrar.conciliar.confirmar', $data);
    }

    public function postConfirmar(Request $request)
    {
        $ingreso = MovimientosCuenta::findOrFail($request->get('ingreso_id'));
        $estado = MovimientosCuenta::findOrFail($request->get('estado_id'));
        $ingreso->conciliar($estado);

        return redirect('registrar/conciliar')->with('mensaje', 'Se conciliaron los movimientos correctamente');
    }
}
