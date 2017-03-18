<?php namespace App\Http\Controllers\Recibos;

use App\Events\CargarPanelesAdicionales;
use App\Helpers\HtmlElement;
use App\Helpers\PanelArchivo;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrearPagoRequest;
use App\Models\App\User;
use App\Models\Inquilino\MovimientosCuenta;
use App\Models\Inquilino\Pago;
use App\Models\Inquilino\Recibo;
use App\Models\Inquilino\Vivienda;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function __construct()
    {
        $this->middleware('inquilino.configurado');
    }

    public function index()
    {
        return redirect('consultas/pagos');
    }

    public function create()
    {
        $data['pago'] = new Pago();
        $data['movimiento'] = new MovimientosCuenta();
        $data['columns'] = Recibo::getDescriptions([
            'checkbox' => new HtmlElement('checkbox', 'pagado[]'),
            'num_recibo',
            'corteRecibo->nombre',
            'monto_total'
        ]);
        $data['vivienda'] = new Vivienda();

        if (!User::esJunta(true)) {
            $data['viviendas'] = auth()->user()->viviendasPropietario->lists('nombre', 'id')->all();
        }
        return view('recibos.pagos.create', $data);
    }

    public function edit($id)
    {
        $data['pago'] = Pago::findOrFail($id);
        if (!$data['pago']->puedeEditar()) {
            return redirect("consultas/pagos")->with(
                ['error' => 'No se puede modificar este pago, debido a que ya esta procesado'],
                400
            );
        }
        $data['recibos'] = $data['pago']->recibos;
        $data['movimiento'] = $data['pago']->movimientoCuenta;
        $data['columns'] = [
            'monto_total',
            'num_recibo',
            'monto_comun',
            'monto_no_comun',
            'deuda_anterior',
            'porcentaje_mora',
            'monto_mora',
            'estatus_display'
        ];

        return view('recibos.pagos.edit', $data);
    }

    public function store(CrearPagoRequest $request)
    {
        $pago = Pago::agregarPago($request->all());
        if ($pago === false) {
            return redirect()->back()->withErrors("Debes seleccionar al menos un recibo a pagar")->withInput();
        } else {
            if ($pago->hasErrors()) {
                return redirect()->back()->withErrors($pago->getErrors())->withInput();
            }
        }

        return redirect('consultas/pagos')->with('mensaje', 'Se guardó el pago correctamente');
    }

    public function update($id, Request $request)
    {
        $pago = Pago::findOrFail($id);
        if (!$pago->puedeEditar()) {
            return redirect("consultas/pagos")->with(
                ['error' => 'No se puede modificar este pago, debido a que ya esta procesado'],
                400
            );
        }
        $movimiento = $pago->movimientoCuenta;
        $movimiento->cuenta_id = $request->get('cuenta_id');
        $movimiento->referencia = $request->get('referencia');
        $movimiento->actualizarCrear();

        return redirect('consultas/pagos')->with('mensaje', 'Se guardó el pago correctamente');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        if ($pago->delete()) {
            return response()->json(['mensaje' => 'Se eliminó el pago correctamente']);
        }

        return response()->json(['error' => 'No se puede eliminar este pago, debido a que ya esta procesado'], 400);
    }

    public function show($id)
    {
        $data['pago'] = Pago::findOrFail($id);
        $data['columns'] = [
            'monto_total',
            'num_recibo',
            'monto_comun',
            'monto_no_comun',
            'deuda_anterior',
            'porcentaje_mora',
            'monto_mora',
            'estatus_display'
        ];
        $data['panelesAdicionales'] = event(new CargarPanelesAdicionales($data['pago'], ['archivos', 'comentarios']));

        return view('recibos.pagos.show', $data);
    }
}
