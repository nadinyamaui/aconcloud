<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25-03-2015
 * Time: 07:24 AM
 */

namespace App\Http\Controllers\Registrar;


use App\Http\Controllers\Controller;
use App\Http\Requests\Conciliacion;
use App\Models\Inquilino\MovimientosCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EstadoCuentaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permisos.junta');
        $this->middleware('inquilino.configurado', ['only' => 'getIndex']);
    }

    public function getIndex()
    {
        $data['movimiento'] = new MovimientosCuenta();
        Cache::forget('movimientosPendientes');
        Cache::forget('movimientosConciliar');

        return view('registrar.estado-cuenta.index', $data);
    }

    public function postIndex(Conciliacion $request)
    {
        $conciliacionHelper = new \App\Helpers\Conciliacion($request->file('archivo'), $request->get('cuenta_id'));
        $conciliacionHelper->preparar($request->get('cuenta_id'));
        $data['conciliacionHelper'] = $conciliacionHelper;
        $data['cuenta'] = $conciliacionHelper->cuenta;
        $data['columnas'] = [
            'referencia',
            'fecha_pago',
            'tipo_movimiento',
            'descripcion',
            'monto_ingreso',
            'monto_egreso'
        ];
        //se guarda en el cache la conciliacion
        Cache::forever('movimientosPendientes', $conciliacionHelper->collectionPendientes->toArray());
        Cache::forever('movimientosConciliar', $conciliacionHelper->collectionConciliar->toArray());

        return view('registrar.estado-cuenta.confirmar', $data);
    }

    public function postConfirmar(Request $request)
    {
        $movimientosPendientes = Cache::pull('movimientosPendientes');
        $movimientosConciliar = Cache::pull('movimientosConciliar');
        $conciliacion = new \App\Helpers\Conciliacion(null, $request->get('cuenta_id'), $movimientosPendientes,
            $movimientosConciliar);
        $conciliacion->confirmarConciliacion();

        return redirect('admin-inquilino/cuentas/' . $conciliacion->cuenta->id);
    }
}