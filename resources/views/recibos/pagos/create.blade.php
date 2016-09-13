@extends('recibos.pagos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Registrar un pago'])
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($pago, ['url' => 'recibos/pagos'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            <div class="col-md-6">
                <fieldset>
                    <legend>¿A que vivienda le vas a registrar el pago?</legend>
                    <div class="row">
                        @if(isset($viviendas))
                            {!! Form::simple('vivienda_id', 12, 'select', [], $viviendas) !!}
                        @else
                            {!! Form::simple('vivienda_id', 12) !!}
                        @endif
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend>Balance de la vivienda</legend>
                    <div class="row">
                        {!!Form::display($vivienda, 'saldo_deudor', 6)!!}
                        {!!Form::display($vivienda, 'saldo_a_favor', 6)!!}
                    </div>
                </fieldset>
            </div>
        </div>

        <fieldset>
            <legend>Recibos pendientes</legend>
            <div class="row">
                <div class="col-md-12" id="tabla-recibos">
                    {!!HTML::tableAjax('App\Models\Inquilino\Recibo', $columns, false, false, false, true,  ["list"=>"consultas/recibos?estatus[]=GEN&estatus[]=VEN&vivienda_id=","url"=>"consultas/recibos"])!!}
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Detalles del pago</legend>
            <div class="row">
                {!!Form::simple('total_relacion', 3)!!}
                {!!Form::simple('monto_pagado', 3)!!}
                {!!Form::simple2($movimiento, 'cuenta_id', 3)!!}
                {!!Form::simple('referencia', 3)!!}
            </div>
        </fieldset>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/recibos/pagos.js')!!}
@endsection