@extends('admin-inquilino.cuentas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Detalles de la cuenta bancaria'])
    <div class="panel-body">
        @include('templates.mensaje')
        <div class="row">
            {!!Form::display($cuenta,'banco->nombre',3)!!}
            {!!Form::display($cuenta,'numero',3)!!}
            {!!Form::display($cuenta,'saldo_actual',3)!!}
            {!!Form::display($cuenta,'saldo_con_fondos',3)!!}
        </div>
        <hr>
        <h4>Movimientos de la cuenta</h4>
        {!!HTML::tableAjax('App\Models\Inquilino\MovimientosCuenta', $columns, false, false, false, false, "consultas/movimientos/cuentas?cuenta_id=".$cuenta->id, false)!!}
    </div>
@endsection