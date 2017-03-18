<?php

namespace App\Http\Controllers\Recibos;

use App\Http\Controllers\Controller;
use App\Models\Inquilino\CorteRecibo;
use Illuminate\Http\Request;

class RecibosController extends Controller
{
    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    public function confirmar($id)
    {
        $data['corte'] = CorteRecibo::findOrFail($id);
        if (!$data['corte']->puedeGenerarRecibos()) {
            return redirect('recibos/cortes/' . $data['corte']->id)
                ->with('error', 'Ya se generarón los recibos de este corte');
        }
        $data['recibos'] = $data['corte']->generarRecibos(false);
        $data['columnas'] = [
            'vivienda->nombre',
            'monto_comun',
            'monto_no_comun',
            'deuda_anterior',
            'deuda_posterior',
            'porcentaje_mora',
            'monto_mora',
            'monto_total',
            'monto_total_con_deuda'
        ];

        return view('recibos.recibos.confirmar', $data);
    }

    public function postConfirmar(Request $request)
    {
        $corte = CorteRecibo::findOrFail($request->get('id'));
        if (!$corte->puedeGenerarRecibos()) {
            return redirect('recibos/cortes/' . $corte->id)->with('error', 'Ya se generarón los recibos de este corte');
        }
        $corte->generarRecibos();

        return redirect('recibos/cortes/' . $corte->id)->with('mensaje', 'Se generarón los recibos correctamente');
    }
}
