@extends('registrar.estado-cuenta.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Confirmar movimientos'])
    @include('templates.mensaje')
    <div class="panel-body">
        <div class="note note-success">
            <h4>¡Se cargaron los registros del estado de cuenta satisfactoriamente!</h4>
            <p>
                La conciliación esta lista para ser procesada, antes de continuar
                verifica que los movimientos sean los correctos, una vez confirmada la operación no se puede revertir el proceso.
            </p>
            <h5>Detalles de la cuenta a conciliar</h5>
            <ul>
                <li><b>Banco</b> {{$cuenta->banco->nombre}}</li>
                <li><b>Cuenta</b> {{$cuenta->numero}}</li>
                <li><b>Saldo Actual</b> {{App\Helpers\Helper::tm($cuenta->saldo_actual)}}</li>
                <li><b>Total de ingresos</b> {{App\Helpers\Helper::tm($conciliacionHelper->totalIngresos)}}</li>
                <li><b>Total de egresos</b> {{App\Helpers\Helper::tm($conciliacionHelper->totalEgresos)}}</li>
                <li><b>Quedarán pendientes </b> {{$conciliacionHelper->collectionPendientes->count()}} <b> registros</b></li>
                <li><b>Se conciliarán </b> {{$conciliacionHelper->collectionConciliar->count()}} <b> registros</b></li>
                <li><b>Saldo luego de la conciliación</b> {{App\Helpers\Helper::tm($conciliacionHelper->saldoFinal+$cuenta->saldo_fondos)}}</li>
            </ul>
        </div>
        <fieldset>
            <legend>Movimientos pendientes</legend>
            {!!HTML::customTable($conciliacionHelper->collectionPendientes,'App\Models\Inquilino\MovimientosCuenta', $columnas)!!}
        </fieldset>
        <fieldset>
            <legend>Movimientos a conciliar</legend>
            {!!HTML::customTable($conciliacionHelper->collectionConciliar,'App\Models\Inquilino\MovimientosCuenta', $columnas)!!}
        </fieldset>
        {!!Form::open(['url'=>'registrar/estado-cuenta/confirmar'])!!}
        {!!Form::hidden('cuenta_id', $cuenta->id)!!}
        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary "><i class="glyphicon glyphicon-check"></i> Confirmar Conciliación</button>
                <a class="btn btn-default" href="{{url('registrar/estado-cuenta')}}"><i class="glyphicon glyphicon-trash"></i> Cancelar</a>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
@endsection