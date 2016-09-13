<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\Alarma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlarmasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = Alarma::getDescriptions([
            'nombre',
            'descripcion',
            'fecha_vencimiento',
            'ind_atendida',
            'atender_link'
        ]);

        return view('alarmas.index', $data);
    }


    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Alarma::filtrarPorUsuario(Auth::id())->ordenar());
    }

    public function redirigir($id)
    {
        $alarma = Alarma::findOrFail($id);
        if ($alarma->link_handle) {
            return redirect($alarma->link_handle);
        }

        return redirect('alarmas/' . $alarma->id);
    }
}
