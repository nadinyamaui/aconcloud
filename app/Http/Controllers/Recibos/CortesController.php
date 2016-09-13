<?php namespace App\Http\Controllers\Recibos;


use App\Events\CargarPanelesAdicionales;
use App\Helpers\PanelArchivo;
use App\Http\Controllers\Controller;
use App\Models\Inquilino\CorteRecibo;
use App\Models\Inquilino\Recibo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CortesController extends Controller
{
    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => ['index', 'esteMes', 'create']]);
        $this->middleware('permisos.junta', ['only'=>['create', 'store']]);
    }

    public function esteMes()
    {
        $hoy = Carbon::now();
        $data['corte'] = CorteRecibo::generarCorte($hoy->format('n'), $hoy->format('Y'));

        return view('recibos.cortes.index', $data);
    }

    public function show($id)
    {
        $data['corte'] = CorteRecibo::findOrFail($id);
        $data['columnas_recibo'] = Recibo::getDescriptions(['vivienda->nombre', 'monto_total']);
        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales($data['corte'], ['archivos', 'comentarios']));

        return view('recibos.cortes.index', $data);
    }

    public function create()
    {
        $data['carbon'] = CorteRecibo::fechaUltimoRecibo();
        $data['carbon']->addMonth();
        $data['hayPendiente'] = CorteRecibo::hayPendiente();

        return view('recibos.cortes.create', $data);
    }

    public function store(Request $request)
    {
        $data['carbon'] = CorteRecibo::fechaUltimoRecibo();
        $data['carbon']->addMonth();
        $corte = CorteRecibo::generarCorte($data['carbon']->month, $data['carbon']->year);
        if (!$corte->movimientosConciliados()) {
            return redirect('recibos/cortes/create')->with('error',
                'Aun quedan movimientos bancarios por conciliar, deben conciliarse primero antes de generar el corte');
        }
        if ($corte->save()) {
            return redirect('consultas/cortes')->with('mensaje', 'Se generó el corte mensual correctamente');
        }

        return redirect()->back()->withErrors($corte->getErrors())->withInput();
    }

    public function destroy($id)
    {
        $corte = CorteRecibo::findOrFail($id);
        if ($corte->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el corte de recibo correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar este corte de recibo, debido a que ya esta procesado'],
            400);
    }
}