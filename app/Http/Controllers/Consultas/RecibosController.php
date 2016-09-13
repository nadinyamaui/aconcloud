<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28-03-2015
 * Time: 09:37 AM
 */

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use App\Http\Responses\DatatableResponse;
use App\Http\Responses\ReporteResponse;
use App\Models\App\Inquilino;
use App\Models\Inquilino\CorteRecibo;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\Recibo;
use App\Models\Inquilino\TipoVivienda;
use Illuminate\Http\Request;

class RecibosController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    public function index(Request $request)
    {
        $data['cortes'] = CorteRecibo::orderBy('ano', 'DESC')->orderBy('mes', 'DESC')->take(12)->get();
        if (!$request->has('corte_id') && is_object($data['cortes']->first())) {
            return redirect('consultas/recibos?corte_id=' . $data['cortes']->first()->id);
        }
        $data['tipos'] = TipoVivienda::all();
        $data['columns'] = Recibo::getDescriptions([
            'vivienda->tipoVivienda->nombre',
            'vivienda->nombre',
            'num_recibo',
            'monto_comun',
            'monto_no_comun',
            'deuda_anterior',
            'porcentaje_mora',
            'monto_mora',
            'monto_total',
            'monto_total_con_deuda',
            'estatus_display'
        ]);

        return view('consultas.recibos.index', $data);
    }

    public function show($id)
    {
        $data = $this->prepararShow($id);

        return view('consultas.recibos.show', $data);
    }

    private function prepararShow($id)
    {
        $data['recibo'] = Recibo::findOrFail($id);
        $data['inquilino'] = Inquilino::$current;
        $data['vivienda'] = $data['recibo']->vivienda;
        $data['corte'] = $data['recibo']->corteRecibo;
        $data['gastos'] = $data['corte']->movimientosGastos()->whereIndGastoNoComun(false)->get();
        $data['fondos'] = Fondo::whereIndCajaChica(false)->get();
        $data['gastosNoComunes'] = $data['vivienda']->gastosNoComunes($data['corte']);
        $data['ingresos'] = $data['corte']->movimientosIngresos()->get();
        $data['corteAnterior'] = $data['corte']->anterior();

        return $data;
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Recibo::aplicarFiltro($request->all()));
    }

    public function descargar($id, Request $request, ReporteResponse $reporte)
    {
        $data = $this->prepararShow($id);
        $data['formato'] = $request->get('formato', 'xls');
        $data['nombre_reporte'] = "Recibo " . $data['recibo']->num_recibo;
        $data['nombreInquilino'] = Inquilino::$current->nombre;

        return $reporte->create($request, 'consultas.recibos.descargar', $data);
    }
}