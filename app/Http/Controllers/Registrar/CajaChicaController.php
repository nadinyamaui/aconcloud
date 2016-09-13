<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25-03-2015
 * Time: 07:24 AM
 */

namespace App\Http\Controllers\Registrar;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReponerCaja;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\MovimientosCuenta;

class CajaChicaController extends Controller
{

    public function __construct()
    {
        $this->middleware('permisos.junta');
        $this->middleware('inquilino.configurado');
    }

    public function reponer()
    {
        $data['fondo'] = Fondo::whereIndCajaChica(true)->first();
        $data['movimiento'] = new MovimientosCuenta();
        $data['columns'] = MovimientosCuenta::getDescriptions([
            'clasificacion->nombre',
            'monto_egreso',
            'forma_pago',
            'fecha_factura',
            'comentarios'
        ]);

        return view('registrar.caja-chica.reponer', $data);
    }

    public function postReponer(ReponerCaja $request)
    {
        $data['fondo'] = Fondo::whereIndCajaChica(true)->first();
        $montoReponer = Helper::tf($request->get('monto_reponer'));
        $ret = $data['fondo']->reponer($request->get('referencia'), $request->get('cuenta_id'), $montoReponer);
        if ($ret === true) {
            return redirect('consultas/gastos')->with("mensaje",
                "Se registró la reposición de caja chica correctamente");
        }

        return redirect()->back()->withInput()->withErrors($ret->getErrors());
    }
}