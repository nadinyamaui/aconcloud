<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\CargoJunta;
use Illuminate\Http\Request;

class CargoJuntasController extends Controller
{

    use BasicCRUDTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['columns'] = CargoJunta::getDescriptions(['nombre']);

        return view('admin.cargos-junta.index', $data);
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
        $cargos = CargoJunta::findOrFail($id);
        if ($cargos->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el cargo de la junta correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar el cargo de la junta, tiene registros asociados'],
            400);
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, CargoJunta::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $cargos = CargoJunta::findOrNew($id);
        $cargos->fill($request->all());
        if ($cargos->save()) {
            return redirect('admin/cargos-junta')->with('mensaje', 'Se guardó el cargo de la junta correctamente');
        }

        return redirect()->back()->withErrors($cargos->getErrors())->withInput();
    }

    private function createEdit($id = 0)
    {
        $data['cargo'] = CargoJunta::findOrNew($id);

        return view('admin.cargos-junta.form', $data);
    }

}
