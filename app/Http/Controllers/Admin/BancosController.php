<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Banco;
use Illuminate\Http\Request;

class BancosController extends Controller
{

    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = Banco::getDescriptions(['nombre']);

        return view('admin.bancos.index', $data);
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
        $banco = Banco::findOrFail($id);
        if ($banco->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el banco correctamente']);
        }

        return response()->json(['mensaje' => 'No se puede eliminar el banco, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Banco::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $banco = Banco::findOrNew($id);
        $banco->fill($request->all());
        if ($banco->save()) {
            return redirect('admin/bancos')->with('mensaje', 'Se guardó el banco correctamente');
        }

        return redirect()->back()->withErrors($banco->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['banco'] = Banco::findOrNew($id);

        return view('admin.bancos.form', $data);
    }
}
