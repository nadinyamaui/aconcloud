<?php

namespace App\Modules\Asambleas\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Models\App\Inquilino;
use App\Modules\Asambleas\Asamblea;
use App\Modules\Asambleas\Asistente;
use App\Modules\Asambleas\Jobs\AsambleaCreada;
use App\Modules\Propuestas\Propuesta;
use Illuminate\Http\Request;

class AsambleasController extends Controller
{
    use BasicCRUDTrait;

    public function __construct()
    {
        $this->middleware('inquilino.configurado');
        $this->middleware('permisos.junta', ['except'=>['index', 'show']]);
    }

    public function index(Request $request)
    {
        $data['asambleas'] = Asamblea::aplicarFiltro($request->get('q'))->orderBy('created_at', 'DESC')->get();

        return view('asambleas::asambleas.index', $data);
    }

    public function show($id)
    {
        $data['asamblea'] = Asamblea::findOrFail($id);

        $data['mensajes'] = $data['asamblea']->mensajesChat;
        $data['asistentesColums'] = Asistente::getDescriptions(['nombre', 'apellido', 'hora_ingreso', 'ind_asistio_boton']);
        $data['propuestas'] = $data['asamblea']->propuestas;
        if ($data['asamblea']->estatus == "en_curso") {
            $data['asamblea']->asistente();
        }
        return view('asambleas::asambleas.show', $data);
    }

    public function destroy($id)
    {
        $asamblea = Asamblea::findOrFail($id);
        if ($asamblea->delete()) {
            return response()->json(['mensaje' => 'Se eliminó la asamblea correctamente']);
        }

        return response()->json(['mensaje' => 'No se puede eliminar la asamblea, tiene registros asociados'], 400);
    }

    public function comenzar($id)
    {
        $asamblea = Asamblea::findOrFail($id);
        if ($asamblea->comenzar()) {
            return redirect('modulos/asambleas/asambleas/'.$id)->with('mensaje', 'Todo listo!. Estamos en vivo preparate para que todo comience');
        }

        return redirect('modulos/asambleas/asambleas/'.$id)->with('error', 'No podemos comenzar, aun no tenemos el link al evento de youtube');
    }

    public function terminada($id)
    {
        $asamblea = Asamblea::findOrFail($id);
        if ($asamblea->terminada()) {
            return redirect('modulos/asambleas/asambleas/'.$id)->with('mensaje', '¡Listo!. Esta asamblea ha culminado');
        }

        return redirect('modulos/asambleas/asambleas/'.$id)->with('error', 'No podemos cerrar, intenta nuevamente');
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $asamblea = Asamblea::findOrNew($id);
        $is_new = !$asamblea->exists;
        $asamblea->fill($request->all());
        if (count($request->get('propuestas', [])) == 0 && $is_new) {
            $asamblea->addError('propuestas', 'Debes seleccionar al menos una propuesta a discutir durante esta asamblea');
        }
        if ($asamblea->save()) {
            if ($is_new) {
                $asamblea->propuestas()->saveMany(Propuesta::findMany($request->get('propuestas')));
                $asamblea->cambiarEstatus();
                if ($asamblea->ind_enviar_email) {
                    $this->dispatch(new AsambleaCreada($asamblea->id));
                }
            }
            return redirect('modulos/asambleas/asambleas')->with('mensaje', 'Se guardó la asamblea correctamente');
        }

        return redirect()->back()->withErrors($asamblea->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['asamblea'] = Asamblea::findOrNew($id);
        $data['usuarios'] = Inquilino::$current->usuarios->lists('nombre_completo', 'id')->all();
        $data['timeSlots'] = Helper::generateTimeSlots();
        return view('asambleas::asambleas.form', $data);
    }
}
