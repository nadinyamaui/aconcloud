<?php

namespace App\Modules\Mensajeria\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Modules\Mensajeria\Http\Requests\EnviarMensajeRequest;
use App\Modules\Mensajeria\Mensaje;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class MensajesController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado');
    }

    public function index(Guard $auth, Request $request)
    {
        if (!$request->has('bandeja')) {
            return redirect('modulos/mensajeria/mensajes?bandeja=entrada');
        }
        $user = $auth->user();
        $base = Mensaje::orderBy('id', 'desc');
        switch ($request->get("bandeja")) {
            case "entrada":
                $data['mensajes'] = $base->whereDestinatarioId($user->id)->whereIndSaliente(false)->simplePaginate(20);
                break;
            case "salida":
                $data['mensajes'] = $base->whereRemitenteId($user->id)->whereIndSaliente(true)->simplePaginate(20);
                break;
            case "papelera":
                $data['mensajes'] = $base->onlyTrashed($user->id)->where(function ($query) use ($user) {
                    $query->whereDestinatarioId($user->id)->orWhere('remitente_id', $user->id);
                })->simplePaginate(20);
                break;
        }
        $data['noLeidos'] = Mensaje::noLeidos($user->id);

        return view('mensajeria::mensajes.index', $data);
    }

    public function create(Guard $auth, Request $request)
    {
        $user = $auth->user();
        $data['mensaje'] = new Mensaje();
        $data['mensaje']->destinatarios = [User::findOrNew($request->get('destinatario_id'))];
        $data['usuarios'] = Inquilino::$current->usuarios->lists('nombre_completo', 'id')->all();
        $data['noLeidos'] = Mensaje::noLeidos($user->id);

        return view('mensajeria::mensajes.create', $data);
    }

    public function store(EnviarMensajeRequest $request)
    {
        $mensaje = Mensaje::enviarMensajes($request->all());
        if ($mensaje->hasErrors()) {
            return redirect()->back()->withInput()->withErrors($mensaje->getErrors());
        }

        return redirect("modulos/mensajeria/mensajes")->with("mensaje", "Se envió el mensaje correctamente");
    }

    public function show($id, Guard $auth)
    {
        $user = $auth->user();
        $data['mensaje'] = Mensaje::findOrFail($id);
        $data['mensaje']->leido();
        $data['noLeidos'] = Mensaje::noLeidos($user->id);

        return view('mensajeria::mensajes.show', $data);
    }

    public function iframe($id)
    {
        $data['mensaje'] = Mensaje::findOrFail($id);

        return view('mensajeria::mensajes.iframe', $data);
    }

    public function borrar(Request $request)
    {
        $mensajes = Mensaje::findMany($request->get('ids'));
        foreach ($mensajes as $mensaje) {
            $mensaje->forceDelete();
        }

        return response()->json([]);
    }

    public function papelera(Request $request)
    {
        Mensaje::destroy($request->get('ids'));
    }
}
