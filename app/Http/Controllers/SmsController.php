<?php namespace App\Http\Controllers;

use App\Models\App\SmsEnviado;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    public function pendientes()
    {
        $mensajes = SmsEnviado::with('destinatario')->whereIndEnviado(false)->whereIndReservado(false)->take(30)->get();
        $mensajes->each(function ($sms) {
            $sms->reservar();
        });

        return response()->json(compact('mensajes'));
    }

    public function enviado($id)
    {
        $sms = SmsEnviado::findOrFail($id);
        $sms->enviado();

        return response()->json(['mensaje' => 'Enviado']);
    }

    public function error($id, Request $request)
    {
        $sms = SmsEnviado::findOrFail($id);
        $sms->error($request->get('error'));

        return response()->json(['mensaje' => 'Enviado']);
    }
}
