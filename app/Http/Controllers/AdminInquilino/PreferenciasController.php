<?php namespace App\Http\Controllers\AdminInquilino;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Inquilino\Preferencia;

class PreferenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    public function index()
    {
        $data['preferencia'] = Preferencia::buscarPreferencias();
        $data['meses'] = Helper::getListaMeses();

        return view('admin-inquilino.preferencias.index', $data);
    }

    public function store(Requests\GuardarPreferenciasRequest $request)
    {
        Preferencia::guardarTodas($request->all());

        return redirect('admin-inquilino/preferencias')->with('mensaje', 'Se guardarón las preferencias correctamente');
    }
}
