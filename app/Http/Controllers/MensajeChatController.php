<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Inquilino\MensajeChat;
use Illuminate\Http\Request;

class MensajeChatController extends Controller
{
    public function store(Request $request)
    {
        $mensaje = MensajeChat::create($request->all());
        if ($mensaje->hasErrors()) {
            return response()->json(['errores' => $mensaje->getErrors()], 400);
        }

        return response()->json(['mensaje' => $mensaje->load('autor')]);
    }
}