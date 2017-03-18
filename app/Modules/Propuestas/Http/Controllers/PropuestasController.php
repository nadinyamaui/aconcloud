<?php namespace App\Modules\Propuestas\Http\Controllers;

use App\Events\CargarPanelesAdicionales;
use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Models\App\Inquilino;
use App\Models\Inquilino\Archivo;
use App\Modules\Propuestas\Http\Middleware\VerificarAccesoPropuesta;
use App\Modules\Propuestas\Propuesta;
use Illuminate\Http\Request;
use App\Modules\Propuestas\Http\Middleware\SoloEditaPropuestasAbiertas;

class PropuestasController extends Controller
{
    use BasicCRUDTrait;

    public function __construct()
    {
        $this->middleware('inquilino.configurado');
        $this->middleware(VerificarAccesoPropuesta::class, ['except' => ['index', 'show']]);
        $this->middleware(SoloEditaPropuestasAbiertas::class, ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        $data['propuestas'] = Propuesta::aplicarFiltro($request->get('q'))->get();

        return view('propuestas::propuestas.index', $data);
    }

    public function show($id)
    {
        $data['propuesta'] = Propuesta::findOrFail($id);
        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales(
            $data['propuesta'],
            ['archivos', 'comentarios']
        ));

        $data['mensajes'] = $data['propuesta']->mensajesChat;

        return view('propuestas::propuestas.show', $data);
    }

    public function destroy($id)
    {
        $propuesta = Propuesta::findOrFail($id);
        if ($propuesta->delete()) {
            return response()->json(['mensaje' => 'Se eliminó la propuesta correctamente']);
        }

        return response()->json(['mensaje' => 'No se puede eliminar la propuesta, tiene registros asociados'], 400);
    }

    public function activarVotacion($id)
    {
        $propuesta = Propuesta::findOrFail($id);
        $propuesta->enVotacion();
        return redirect('modulos/propuestas/propuestas/' . $propuesta->id)->with('mensaje', 'Esta propuesta ya esta
        disponible para realizar votaciones');
    }

    public function cerrarVotacion($id)
    {
        $propuesta = Propuesta::findOrFail($id);
        $propuesta->cerrarVotacion();
        return redirect('modulos/propuestas/propuestas/' . $propuesta->id)->with('mensaje', 'Se cerro el proceso de votación correctamente');
    }

    public function recordarVecinos($id)
    {
        $propuesta = Propuesta::findOrFail($id);
        $propuesta->recordarVecinos();
        return redirect('modulos/propuestas/propuestas/' . $propuesta->id)->with('mensaje', 'Se le ha enviado una notificación por SMS y Correo electrónico a los vecinos que aun no han ejercido su derecho al voto');
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $propuesta = Propuesta::findOrNew($id);
        $propuesta->fill($request->all());
        if ($propuesta->save()) {
            $propuesta->autorizados()->sync($request->get('autorizados', []));
            Archivo::asociarArchivos($request->get('archivos_cargados'), $propuesta->id);

            return redirect('modulos/propuestas/propuestas')->with('mensaje', 'Se guardó la propuesta correctamente');
        }

        return redirect()->back()->withErrors($propuesta->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['propuesta'] = Propuesta::findOrNew($id);

        $data['usuarios'] = Inquilino::$current->usuarios->where('codigo_grupo_activo', 'junta')->lists('nombre_completo', 'id')->all();

        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales(
            $data['propuesta'],
            ['archivos', 'comentarios']
        ));

        return view('propuestas::propuestas.form', $data);
    }
}
