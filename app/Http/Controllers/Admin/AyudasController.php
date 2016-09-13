<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Ayuda;
use Illuminate\Http\Request;

class AyudasController extends Controller
{

    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = Ayuda::getDescriptions([
            'id',
            'titulo',
            'tipoAyuda->nombre',
            'autor->nombre_completo',
            'descripcion'
        ]);

        return view('admin.ayudas.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ayuda = Ayuda::findOrFail($id);
        if ($ayuda->delete()) {
            return response()->json(['mensaje' => 'Se eliminó la ayuda correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar la ayuda, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Ayuda::with('tipoAyuda'));
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $ayuda = Ayuda::findOrNew($id);
        $ayuda->fill($request->all());
        if ($ayuda->save()) {
            return redirect('admin/ayudas')->with('mensaje', 'Se guardó la ayuda correctamente');
        }

        return redirect()->back()->withErrors($ayuda->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['ayuda'] = Ayuda::findOrNew($id);

        return view('admin.ayudas.form', $data);
    }

}
