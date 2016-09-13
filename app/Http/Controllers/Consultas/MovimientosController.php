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
use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\MovimientosCuenta;
use Illuminate\Http\Request;

class MovimientosController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    public function cuentas(DatatableResponse $handler, Request $request)
    {
        $cuenta = Cuenta::findOrFail($request->get('cuenta_id'));
        $query = MovimientosCuenta::where(function ($query) use ($cuenta) {
            $query->whereCuentaId($cuenta->id);
            $query->orWhereIn('fondo_id', $cuenta->fondos->lists('id')->all());
        });

        return $handler->create($request, $query);
    }

    public function fondos(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, MovimientosCuenta::aplicarFiltro($request->all()));
    }
}