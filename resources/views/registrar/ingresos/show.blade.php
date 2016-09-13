@extends('registrar.ingresos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Detalles del ingreso'])
    <div class="panel-body">
        @include('templates.errores')
        <fieldset>
            <legend>Detalles del ingreso</legend>
            <div class="row">
                {!!Form::display($ingreso, 'clasificacion->nombre', 3)!!}
                {!!Form::display($ingreso,'fecha_factura', 3)!!}
                {!!Form::display($ingreso,'numero_factura', 3)!!}
                {!!Form::display($ingreso,'monto_ingreso', 3)!!}
            </div>
            <div class="row">
                {!!Form::display($ingreso, 'referencia', 3)!!}
                {!!Form::display($ingreso, 'cuenta->nombre', 3)!!}
                {!!Form::display($ingreso, 'comentarios', 3)!!}
            </div>
            @if($ingreso->ind_movimiento_en_cuotas)
                <h4>Detalle de las cuotas</h4>
                <div class="row">
                    {!!Form::display($ingreso,'ind_movimiento_en_cuotas', 3)!!}
                    {!!Form::display($ingreso,'cuota_numero', 3)!!}
                    {!!Form::display($ingreso,'total_cuotas', 3)!!}
                    {!!Form::display($ingreso,'monto_inicial', 3)!!}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <a href="{{url('consultas/ingresos')}}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Volver</a>
                </div>
            </div>
        </fieldset>
    </div>
@endsection