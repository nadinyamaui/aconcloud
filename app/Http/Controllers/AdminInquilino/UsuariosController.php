<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Inquilino;
use App\Models\App\InquilinoUser;
use App\Models\App\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{

    use BasicCRUDTrait;

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = User::getDescriptions(['nombre', 'apellido', 'email', 'cedula', 'ind_activo']);

        return view('admin-inquilino.usuarios.index', $data);
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
        if ($usuario->deleteFromInquilino()) {
            return response()->json(['mensaje' => 'Se eliminó el usuario correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el usuario, tiene registros asociados']);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, Inquilino::$current->usuarios());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $usuario = User::updateCreate($request->all());
        if (!$usuario->hasErrors()) {
            if ($request->ajax()) {
                return response()->json(['mensaje' => 'Se guardó el usuario correctamente']);
            }

            return redirect('admin-inquilino/usuarios')->with('mensaje', 'Se guardó el usuario correctamente');
        }
        if ($request->ajax()) {
            return response()->json(['errores' => $usuario->getErrors()], 400);
        }

        return redirect()->back()->withErrors($usuario->getErrors())->withInput();
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['usuario'] = User::findOrNew($id);
        $data['rol'] = $data['usuario']->inquilino;
        if (is_null($data['rol'])) {
            $data['rol'] = new InquilinoUser();
        }
        if ($request->ajax()) {
            return view('admin-inquilino.usuarios.modal', $data);
        }

        return view('admin-inquilino.usuarios.form', $data);
    }
}
