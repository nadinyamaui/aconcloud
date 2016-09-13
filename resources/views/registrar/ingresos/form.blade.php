@extends('registrar.ingresos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Registrar un nuevo ingreso'])
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($ingreso, ['url'=>'registrar/ingresos'])!!}
        {!!Form::hidden('id')!!}
        {!!Form::hidden('forma_pago','banco')!!}
        {!!Form::hidden('tipo_movimiento','NC')!!}
        <fieldset>
            <legend>¿Que Ingreso obtuviste?</legend>
            <div class="row">
                {!!Form::simple('clasificacion_id', 4, 'select', [], $clasificaciones)!!}
                {!!Form::simple('fecha_factura', 4)!!}
                {!!Form::simple('numero_factura', 4)!!}
            </div>
            <div class="row">
                {!!Form::simple('monto_ingreso', 4)!!}
                {!!Form::simple('comentarios', 8, 'textarea')!!}
            </div>
        </fieldset>
        <fieldset>
            <legend>¿Donde lo recibiste?</legend>
            <div class="row">
                {!!Form::simple('cuenta_id', 6)!!}
                {!!Form::simple('referencia', 6)!!}
            </div>
            <div class="row">
                {!!Form::simple('ind_movimiento_en_cuotas', 2)!!}
                <div id="movimiento-en-cuotas">
                    {!!Form::simple('total_cuotas', 4)!!}
                </div>
            </div>
        </fieldset>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/registrar/ingresos.js')!!}
@endsection