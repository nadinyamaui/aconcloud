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
use App\Models\Inquilino\Pago;
use Illuminate\Http\Request;

class PagosController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado');
    }

    public function index()
    {
        $data['columns'] = Pago::getDescriptions([
            'vivienda->nombre',
            'monto_pagado',
            'total_relacion',
            'estatus_display'
        ]);

        return view('consultas.pagos.index', $data);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Pago::aplicarFiltro($request->all()));
    }
}