<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25-03-2015
 * Time: 07:24 AM
 */

namespace App\Http\Controllers\Graficos;


use App\Http\Controllers\Controller;
use App\Http\Responses\GraficoResponse;
use App\Models\Inquilino\CorteRecibo;
use App\Models\Inquilino\TipoVivienda;
use Illuminate\Http\Request;

class TipoViviendasController extends Controller
{

    public function getCorte(Request $request, GraficoResponse $graficoResponse)
    {
        if ($request->has('corte_id')){
            $corte = CorteRecibo::findOrFail($request->get('corte_id'));
            $montos = TipoVivienda::all();
            foreach ($montos as $tipo) {
                $tipo->monto_pagar = $corte->monto_total * $tipo->porcentaje_pago / 100;
            }
        } else {
            $montos = TipoVivienda::generarCorte($request->get('mes'), $request->get('ano'));
        }

        return $graficoResponse->create($montos, ['nombre', 'monto_pagar']);
    }
}