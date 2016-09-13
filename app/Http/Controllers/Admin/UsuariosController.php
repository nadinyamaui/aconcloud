<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\InquilinoUser;
use App\Models\App\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = User::getDescriptions(['nombre', 'apellido', 'email', 'cedula', 'ind_activo']);

        return view('admin.usuarios.index', $data);
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
        $usuario = User::findOrFail($id);
        if ($usuario->deleteFromAdministrator()) {
            return response()->json(['mensaje' => 'Se eliminó el usuario correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el usuario, tiene registros asociados'], 400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, User::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $usuario = User::updateCreate($request->all());
        if (!$usuario->hasErrors()) {
            return redirect('admin/usuarios')->with('mensaje', 'Se guardó el usuario correctamente');
        }

        return redirect()->back()->withErrors($usuario->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['usuario'] = User::findOrNew($id);
        $data['rol'] = new InquilinoUser();

        return view('admin.usuarios.form', $data);
    }
}
