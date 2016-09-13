@extends('admin-inquilino.fondos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Detalles del fondo'])
    <div class="panel-body">
        @include('templates.mensaje')
        <div class="row">
            {!!Form::display($fondo,'nombre',4)!!}
            {!!Form::display($fondo,'saldo_actual',4)!!}
            {!!Form::display($fondo,'ind_caja_chica',4)!!}
        </div>
        <div class="row">
            {!!Form::display($fondo,'porcentaje_reserva',4)!!}
            {!!Form::display($fondo,'monto_maximo',4)!!}
            {!!Form::display($fondo,'cuenta->nombre',4)!!}
        </div>
        <hr>
        <h4>Movimientos {{$fondo->nombre}}</h4>
        {!!HTML::tableAjax('App\Models\Inquilino\MovimientosCuenta', $columns, false, false, false, false, "consultas/movimientos/fondos?fondo_id=".$fondo->id, false)!!}
    </div>
@endsection