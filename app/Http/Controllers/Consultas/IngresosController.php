<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25-03-2015
 * Time: 07:24 AM
 */

namespace App\Http\Controllers\Consultas;


use App\Http\Controllers\Controller;
use App\Http\Responses\DatatableResponse;
use App\Models\App\User;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use App\Models\Inquilino\MovimientosCuenta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IngresosController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'getIndex']);
    }

    public function getIndex(Request $request)
    {
        $data['mesActual'] = Carbon::now()->format('n');
        $data['anoActual'] = Carbon::now()->format('Y');
        $data['clasificaciones'] = ClasificacionIngresoEgreso::whereIndEgreso(false)->whereNull("codigo")->get();
        $data['columns'] = MovimientosCuenta::getDescriptions([
            'clasificacion->nombre',
            'monto_ingreso',
            'fecha_factura',
            'estatus_display',
            'referencia'
        ]);
        $data['es_junta'] = User::esJunta(true);

        return view('consultas.ingresos.index', $data);
    }

    public function postDatatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, MovimientosCuenta::aplicarFiltro($request->all())->ingreso());
    }
}