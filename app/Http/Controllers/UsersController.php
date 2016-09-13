<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\User;
use App\Models\Inquilino\Alarma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function perfil()
    {
        $data['user'] = auth()->user();
        return view('users.perfil', $data);
    }

    public function guardarPerfil(Request $request)
    {
        $usuario = User::updateCreate(['id' => auth()->id()] + $request->all(), false);
        if (!$usuario->hasErrors()) {
            return redirect('users/perfil')->with('mensaje', 'Se guardaton tus datos correctamente');
        }

        return redirect()->back()->withErrors($usuario->getErrors())->withInput();
    }

    public function guardarFoto(Request $request)
    {
        $usuario = auth()->user();
        $usuario->uploadProfilePicture($request->file('file'));
        if (!$usuario->hasErrors()) {
            $data['mensaje'] = "Se guardo la foto correctamente";
            $data['object'] = $usuario;

            return response()->json($data);
        }

        return response()->json(['errores' => $usuario->getErrors()], 400);
    }
}
