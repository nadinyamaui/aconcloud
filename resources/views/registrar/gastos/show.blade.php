@extends('registrar.gastos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Detalles del gasto'])
    <div class="panel-body">
        @include('templates.errores')
        <fieldset>
            <legend>Detalles del gasto</legend>
            <div class="row">
                {!!Form::display($gasto, 'clasificacion->nombre', 3)!!}
                {!!Form::display($gasto,'fecha_factura', 3)!!}
                {!!Form::display($gasto,'numero_factura', 3)!!}
                {!!Form::display($gasto,'monto_egreso', 3)!!}
            </div>
            <div class="row">
                {!!Form::display($gasto, 'forma_pago', 3)!!}
                {!!Form::display($gasto, 'referencia', 3)!!}
                {!!Form::display($gasto, 'cuenta->nombre', 3)!!}
                {!!Form::display($gasto, 'fondo->nombre', 3)!!}
            </div>
            <div class="row">
                {!!Form::display($gasto,'comentarios', 4)!!}
            </div>
            @if($gasto->ind_movimiento_en_cuotas)
                <h4>Detalle de las cuotas</h4>
                <div class="row">
                    {!!Form::display($gasto,'ind_movimiento_en_cuotas', 3)!!}
                    {!!Form::display($gasto,'cuota_numero', 3)!!}
                    {!!Form::display($gasto,'total_cuotas', 3)!!}
                    {!!Form::display($gasto,'monto_inicial', 3)!!}
                </div>
            @endif
            @if($gasto->viviendas->count()>0)
                <h4>Viviendas involucradas</h4>
                {!!HTML::customTable($gasto->viviendas,'App\Models\Inquilino\Vivienda', ['tipoVivienda->nombre','nombre'])!!}
            @endif
            <div class="row">
                <div class="col-md-12">
                    <a href="{{url('consultas/gastos')}}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Volver</a>
                </div>
            </div>
        </fieldset>
    </div>
@endsection