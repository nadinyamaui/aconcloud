<?php namespace App\Modules\Propuestas\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\Vivienda;
use App\Modules\Propuestas\Jobs\VotoRegistrado;
use App\Modules\Propuestas\Propuesta;
use App\Modules\Propuestas\Votacion;
use Illuminate\Http\Request;

class VotacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('inquilino.configurado');
    }

    public function index($propuesta_id)
    {
        $data['propuesta'] = Propuesta::findOrFail($propuesta_id);
        $data['votaciones'] = $data['propuesta']->votaciones;
        $data['columnas_votacion_pendientes'] = Votacion::getDescriptions(['nombre_apartamento', 'nombre_propietario']);
        $data['columnas_votacion_total'] = Votacion::getDescriptions(['nombre_apartamento', 'nombre_votante', 'ind_en_acuerdo', 'comentarios']);

        return view('propuestas::votaciones.index', $data);
    }

    public function datatable(Request $request, DatatableResponse $handler)
    {
        return $handler->create($request, Votacion::filtrar($request->all()));
    }

    public function votar($propuesta_id)
    {
        $data['propuesta'] = Propuesta::findOrFail($propuesta_id);
        if($data['propuesta']->estatus != "en_votacion"){
            return redirect('modulos/propuestas/propuestas/'.$propuesta_id)->with('error', 'No se puede votar por esta propuesta');

        }
        $data['viviendas'] = Vivienda::wherePropietarioId(auth()->id())->get();
        $data['usuario'] = auth()->user();
        $data['voto'] = Votacion::whereIn('vivienda_id', $data['viviendas']->lists('id')->all())
            ->wherePropuestaId($propuesta_id)
            ->whereIndCerrado(false)
            ->first();

        if(!is_object($data['voto'])){
            return redirect('modulos/propuestas/propuestas/'.$propuesta_id.'/votaciones')->with('mensaje', 'Ya votaste para esta propuesta, espera que el administrador cierre el proceso de votaci&oacute;n');
        }
        session()->set('voto_activo_id', $data['voto']->id);

        return view('propuestas::votaciones.votar', $data);
    }

    public function procesarVoto(Request $request, $propuesta_id)
    {
        $voto = Votacion::findOrFail(session('voto_activo_id'));

        $voto->user_id = auth()->id();
        $voto->ind_en_acuerdo = $request->get('ind_en_acuerdo');
        $voto->comentarios = $request->get('comentarios');
        $voto->ind_cerrado = true;
        $voto->save();

        $this->dispatch(new VotoRegistrado($propuesta_id, $voto->id));
        return redirect('modulos/propuestas/propuestas/'.$propuesta_id.'/votaciones')->with('mensaje', 'Se ha registrado tu voto correctamente, gracias por ejercer tu derecho al voto');
    }
}

