<?php

namespace App\Modules\Asambleas\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Inquilino;
use App\Modules\Asambleas\Asamblea;
use App\Modules\Asambleas\Asistente;
use App\Modules\Asambleas\Http\Requests\CambiarEstatusAsistenteRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Config;

class AsistentesController extends Controller
{
    public function datatable($asamblea_id, DatatableResponse $handler, Request $request)
    {
        $handler->default_order_by = false;
        $usersTable = Config::get('database.connections.app.database') . '.users';
        $query = Asistente::join($usersTable, $usersTable . '.id', '=', 'asambleas_asamblea_user.user_id')
            ->select(['asambleas_asamblea_user.*', $usersTable . '.nombre', $usersTable . '.apellido']);

        return $handler->create($request, $query->whereAsambleaId($asamblea_id));
    }

    public function estatus(CambiarEstatusAsistenteRequest $request)
    {
        $asistente = Asistente::findOrFail($request->get('asistente_id'));
        $asistente->ind_asistio = $request->get('estatus');
        if($asistente->ind_asistio){
            $asistente->hora_ingreso = Carbon::now()->format('H:i');
        }else{
            $asistente->hora_ingreso = null;
        }
        $asistente->save();

        return response()->json(['mensaje'=>'Se guardaron los datos correctamente']);
    }
}