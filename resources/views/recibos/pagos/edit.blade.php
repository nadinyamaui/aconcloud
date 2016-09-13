@extends('recibos.pagos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Modificar pago'])
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($pago, ['url'=>'recibos/pagos'])!!}
        {!!Form::hidden('id')!!}
        <fieldset>
            <legend>Detalles del pago</legend>
            <div class="row">
                {!!Form::display($pago, 'total_relacion', 2)!!}
                {!!Form::display($pago, 'monto_pagado', 2)!!}
                {!!Form::simple2($movimiento, 'cuenta_id', 4)!!}
                {!!Form::simple('referencia', 4)!!}
            </div>
        </fieldset>
        <fieldset>
            <legend>Recibos</legend>
            {!!HTML::customTable($recibos,'App\Models\Inquilino\Recibo', $columns)!!}
        </fieldset>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/recibos/pagos.js')!!}
@endsection