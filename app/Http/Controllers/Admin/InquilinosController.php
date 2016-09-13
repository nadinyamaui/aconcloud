<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Inquilino;
use Illuminate\Http\Request;

class InquilinosController extends Controller
{

    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = Inquilino::getDescriptions(['nombre', 'host', 'descripcion', 'email_administrador']);

        return view('admin.inquilinos.index', $data);
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
        $inquilino = Inquilino::findOrFail($id);
        if ($inquilino->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el inquilino correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el inquilino, tiene registros asociados'], 400);
    }

    public function instalar($id)
    {
        $inquilino = Inquilino::findOrFail($id);
        $inquilino->instalar();

        return redirect('admin/inquilinos')->with('mensaje', 'Se instaló el inquilino correctamente');
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Inquilino::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $inquilino = Inquilino::findOrNew($id);
        $inquilino->fill($request->all());
        if ($inquilino->save()) {
            $inquilino->modulos()->sync($request->get('modulos', []));

            return redirect('admin/inquilinos')->with('mensaje', 'Se guardó el inquilino correctamente');
        }

        return redirect()->back()->withErrors($inquilino->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['inquilino'] = Inquilino::findOrNew($id);

        return view('admin.inquilinos.form', $data);
    }

}
