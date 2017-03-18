<?php

namespace App\Modules\Comentarios\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Comentarios\Comentario;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{

    public function store(Request $request)
    {
        $comentario = new Comentario();
        $comentario->fill($request->all());
        if ($comentario->save()) {
            $data['cols'] = $request->get('cols');
            if (is_object($comentario->item)) {
                $data['comentarios'] = $comentario->item->comentarios()->get();
            } else {
                $data['comentarios'] = Comentario::whereItemType($comentario->item_type)->whereNull('item_id')->get();
            }
            $data['comentarioNuevo'] = new Comentario([
                'item_id'   => $comentario->item_id,
                'item_type' => $comentario->item_type
            ]);

            $dataJSON['vista'] = view("comentarios::panel", $data)->render();
            $dataJSON['mensaje'] = 'Se publicó tu comentario correctamente';

            return response()->json($dataJSON);
        }

        return response()->json(['errores' => $comentario->getErrors()], 400);
    }

    public function destroy($id, Request $request)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        $data['comentarios'] = $comentario->item->comentarios()->get();
        $data['comentarioNuevo'] = new Comentario([
            'item_id'   => $comentario->item_id,
            'item_type' => $comentario->item_type
        ]);

        $data['cols'] = $request->get('cols');
        $dataJSON['vista'] = view("comentarios::panel", $data)->render();
        $dataJSON['mensaje'] = 'Se eliminó tu comentario correctamente';

        return response()->json($dataJSON);
    }
}
