<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 13-03-2015
 * Time: 11:14 PM
 */

namespace App\Http\Controllers\AdminInquilino;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarPreferenciasRequest;
use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\Preferencia;
use App\Models\Inquilino\TipoVivienda;
use App\Models\Inquilino\Vivienda;
use Illuminate\Http\Request;

class ConfigurarController extends Controller
{

    public function __construct()
    {
        $this->middleware('inquilino.configurado', ['only' => ['paso9']]);
        $this->middleware('ingreso.configuracion', ['except' => ['paso9']]);
    }

    public function paso1()
    {
        $data['paso'] = 1;

        return view('admin-inquilino.configurar.paso1', $data);
    }

    public function postPaso1()
    {
        return redirect('admin-inquilino/configurar/paso2');
    }

    public function paso2()
    {
        $data['paso'] = 2;
        $data['columns'] = User::getDescriptions(['nombre', 'apellido', 'email']);

        return view('admin-inquilino.configurar.paso2', $data);
    }

    public function postPaso2()
    {
        return redirect('admin-inquilino/configurar/paso3');
    }

    public function paso3()
    {
        $data['paso'] = 3;
        $data['tipos'] = TipoVivienda::all();
        $data['tipo'] = new TipoVivienda();

        return view('admin-inquilino.configurar.paso3', $data);
    }

    public function postPaso3(Request $request)
    {
        $ids = $request->get('id');
        foreach ($ids as $key => $id) {
            $tipo = TipoVivienda::findOrNew($id);
            $tipo->nombre = $request->get('nombre')[$key];
            $tipo->cantidad_apartamentos = $request->get('cantidad_apartamentos')[$key];
            $tipo->porcentaje_pago = Helper::tf($request->get('porcentaje_pago')[$key]);
            $tipo->save();
        }
        if (!$request->has('solo_guardar') && TipoVivienda::verificarConfiguracion()) {
            TipoVivienda::crearViviendas();

            return redirect('admin-inquilino/configurar/paso4');
        }
        if (!$request->has('solo_guardar')) {
            return redirect('admin-inquilino/configurar/paso3')->with('error',
                'El total de porcentajes debe sumar 100, verifica la configuración');
        }

        return redirect('admin-inquilino/configurar/paso3')->with('mensaje', 'Se guardarón los cambios correctamente');
    }

    public function paso4()
    {
        $data['paso'] = 4;
        $data['columns'] = Vivienda::getDescriptions([
            'tipoVivienda->nombre',
            'numero_apartamento',
            'piso',
            'torre',
            'saldo_deudor',
            'saldo_a_favor'
        ]);

        return view('admin-inquilino.configurar.paso4', $data);
    }

    public function postPaso4()
    {
        return redirect('admin-inquilino/configurar/paso5');
    }

    public function paso5()
    {
        $data['paso'] = 5;
        $data['columns'] = Cuenta::getDescriptions([
            'banco->nombre',
            'numero',
            'saldo_actual',
            'saldo_con_fondos',
            'ind_activa'
        ]);

        return view('admin-inquilino.configurar.paso5', $data);
    }

    public function postPaso5()
    {
        return redirect('admin-inquilino/configurar/paso6');
    }

    public function paso6()
    {
        $data['paso'] = 6;
        $data['columns'] = Fondo::getDescriptions([
            'nombre',
            'saldo_actual',
            'ind_caja_chica',
            'porcentaje_reserva',
            'cuenta->numero',
            'ind_activo'
        ]);

        return view('admin-inquilino.configurar.paso6', $data);
    }

    public function postPaso6()
    {
        return redirect('admin-inquilino/configurar/paso7');
    }

    public function paso7()
    {
        $data['paso'] = 7;
        $data['columns'] = ClasificacionIngresoEgreso::getDescriptions([
            'nombre',
            'dia_estimado',
            'ind_fijo',
            'monto',
            'ind_egreso'
        ]);

        return view('admin-inquilino.configurar.paso7', $data);
    }

    public function postPaso7()
    {
        return redirect('admin-inquilino/configurar/paso8');
    }

    public function paso8()
    {
        $data['paso'] = 8;
        $data['preferencia'] = Preferencia::buscarPreferencias();
        $data['meses'] = Helper::getListaMeses();

        return view('admin-inquilino.configurar.paso8', $data);
    }

    public function postPaso8(GuardarPreferenciasRequest $request)
    {
        Preferencia::guardarTodas($request->all());
        $inquilino = Inquilino::$current;
        $paso = $inquilino->configurado();
        if ($paso) {
            return redirect('admin-inquilino/configurar/paso9');
        }

        return redirect()->back()->withErrors($inquilino->getErrors());
    }

    public function paso9()
    {
        $data['paso'] = 9;

        return view('admin-inquilino.configurar.paso9', $data);
    }

    public function generarToken()
    {
        $data['inquilino'] = Inquilino::$current;
        $data['inquilino']->generarTokenAcceso();

        return view('admin-inquilino.configurar.generar-token', $data);
    }
}