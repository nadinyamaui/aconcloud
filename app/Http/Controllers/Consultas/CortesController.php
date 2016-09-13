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
use App\Models\Inquilino\CorteRecibo;
use Illuminate\Http\Request;

class CortesController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    public function index()
    {
        $data['columns'] = CorteRecibo::getDescriptions([
            'nombre',
            'fecha_vencimiento',
            'ingresos',
            'gastos_comunes',
            'gastos_no_comunes',
            'total_fondos',
            'estatus_display'
        ]);

        return view('consultas.cortes.index', $data);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, CorteRecibo::orderBy('ano', 'DESC')->orderBy('mes', 'DESC'));
    }
}