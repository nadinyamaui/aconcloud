<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\Inquilino\MovimientosPeriodoJunta;
use App\Models\Inquilino\PeriodoJunta;
use App\Models\Inquilino\PeriodoJuntaUser;
use Illuminate\Http\Request;

class PeriodoJuntaController extends Controller
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
        $data['columns'] = PeriodoJunta::getDescriptions(['fecha_desde', 'fecha_hasta']);

        return view('admin-inquilino.periodo-junta.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $periodo = PeriodoJunta::findOrFail($id);
        if ($periodo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el periodo de la junta de condominio correctamente']);
        }

        return response()->json(
            ['error' => 'No se puede eliminar el periodo de la junta de condominio , tiene registros asociados'],
            400
        );
    }

    public function datatable(DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, PeriodoJunta::query());
    }

    private function storeUpdate(Request $request, $id = null)
    {
        $periodo = PeriodoJunta::findOrNew($id);
        $periodo->fill($request->all());
        if ($periodo->save()) {
            if ($request->ajax()) {
                return response()->json(['mensaje' => 'Se guardó el periodo de la junta correctamente']);
            }

            return redirect('admin-inquilino/periodo-junta')->with(
                'mensaje',
                'Se guardó el periodo de la junta correctamente'
            );
        }
        if ($request->ajax()) {
            return response()->json(['errores' => $periodo->getErrors()], 400);
        }

        return redirect()->back()->withErrors($periodo->getErrors())->withInput();
    }

    private function createEdit($id = 0, Request $request)
    {
        $data['periodo'] = PeriodoJunta::findOrNew($id);
        $data['columns'] = PeriodoJuntaUser::getDescriptions(['cargoJunta->nombre', 'user->nombre_completo']);

        return view('admin-inquilino.periodo-junta.form', $data);
    }
}
