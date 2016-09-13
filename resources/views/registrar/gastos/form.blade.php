@extends('registrar.gastos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Registrar un nuevo gasto'])
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($gasto, ['url'=>'registrar/gastos'])!!}
        {!!Form::hidden('id')!!}
        {!!Form::hidden('tipo_movimiento','ND')!!}
        <fieldset>
            <legend>¿Que gastaste?</legend>
            <div class="row">
                {!!Form::simple('clasificacion_id', 4, 'select', [], $clasificaciones)!!}
                {!!Form::simple('fecha_factura', 4)!!}
                {!!Form::simple('numero_factura', 4)!!}
            </div>
            <div class="row">
                {!!Form::simple('monto_egreso', 4)!!}
                {!!Form::simple('comentarios', 8, 'textarea')!!}
            </div>
        </fieldset>
        <fieldset>
            <legend>¿Cómo lo pagaste?</legend>
            <div class="row">
                <div class="col-xs-12 col-md-4 form-group">
                    <label for="forma_pago">¿Con que lo pagaste?</label>
                    <br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default">
                            {!!Form::radio('forma_pago','efectivo', $gasto->forma_pago=="efectivo", ['id'=>'forma_pago'])!!} Efectivo
                        </label>
                        <label class="btn btn-default">
                            {!!Form::radio('forma_pago','banco', $gasto->forma_pago=="banco", ['id'=>'forma_pago'])!!} Banco
                        </label>
                    </div>
                    <p id="gasto-efectivo" style="display: none;">Cuando los pagos son en efectivo se afecta automaticamente el saldo de la caja chica</p>
                </div>
                {!!Form::simple('ind_movimiento_en_cuotas', 4)!!}
                <div id="movimiento-en-cuotas">
                    {!!Form::simple('total_cuotas', 4)!!}
                </div>
            </div>
            <div id="gasto-banco" style="display: none;">
                <div class="row">
                    <div class="col-xs-4 col-md-4 form-group">
                        <label for="forma_pago">¿De donde sacaste el dinero?</label>
                        <br>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                {!!Form::radio('origen_dinero','cuenta', $gasto->cuenta_id!=null, ['id'=>'origen_dinero'])!!} Cuenta
                            </label>
                            <label class="btn btn-default">
                                {!!Form::radio('origen_dinero','fondo', $gasto->fondo_id!=null, ['id'=>'origen_dinero'])!!} Fondo
                            </label>
                        </div>
                    </div>
                    {!!Form::simple('referencia', 4)!!}
                    <div id="origen-dinero-cuenta" style="display: none;">
                        {!!Form::simple('cuenta_id', 4)!!}
                    </div>
                    <div id="origen-dinero-fondo" style="display: none;">
                        {!!Form::simple('fondo_id', 4)!!}
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset id="gasto-no-comun">
            <legend>¿Este gasto es no común? Cuales fueron las viviendas responsables</legend>
            <div class="row">
                {!!Form::multiselect('viviendas')!!}
            </div>
        </fieldset>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/registrar/gastos.js')!!}
@endsection