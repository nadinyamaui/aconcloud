<?php namespace App\Http\Controllers\AdminInquilino;

use App\Http\Controllers\BasicSecondLevelCRUDTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Responses\DatatableResponse;
use App\Models\App\Inquilino;
use App\Models\Inquilino\MovimientosPeriodoJuntaUser;
use App\Models\Inquilino\PeriodoJunta;
use App\Models\Inquilino\PeriodoJuntaUser;
use Illuminate\Http\Request;

class PeriodoJuntaUsersController extends Controller
{

    use BasicSecondLevelCRUDTrait;

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($element_id, Request $request, $id)
    {
        $periodo = PeriodoJuntaUser::findOrFail($id);
        if ($periodo->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el periodo de la junta de condominio correctamente']);
        }

        return response()->json(
            ['error' => 'No se puede eliminar el periodo de la junta de condominio , tiene registros asociados'],
            400
        );
    }

    public function datatable($id, DatatableResponse $handler, Request $request)
    {
        return $handler->create($request, PeriodoJuntaUser::wherePeriodoJuntaId($id));
    }

    private function storeUpdate($element_id, Request $request, $id = null)
    {
        $user = PeriodoJuntaUser::findOrNew($id);
        $user->fill($request->all());
        $user->periodo_junta_id = $element_id;
        if ($user->save()) {
            return response()->json(['mensaje' => 'Se guardó el periodo de la junta correctamente']);
        }

        return response()->json(['errores' => $user->getErrors()], 400);
    }

    private function createEdit($periodo_id, $id = 0, Request $request)
    {
        $data['periodo'] = PeriodoJunta::findOrNew($periodo_id);
        $data['user'] = PeriodoJuntaUser::findOrNew($id);
        $data['usuarios'] = Inquilino::$current->usuarios->lists('nombre_completo', 'id')->all();
        $data['usuarios'][''] = "Seleccione";

        return view('admin-inquilino.periodo-junta.users', $data);
    }
}
