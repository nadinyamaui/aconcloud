@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Registrar</a></li>
        <li><a href="#">Caja Chica</a></li>
        <li class="active">Reponer</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Reposición de caja chica <small>Aqui puedes registrar la reposición de la caja chica</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Detalles de la caja chica'])
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
                    <h4>Movimientos pendientes de {{$fondo->nombre}}</h4>
                    {!!HTML::tableAjax('App\Models\Inquilino\MovimientosCuenta', $columns, false, true, true, true, ["list"=>"consultas/movimientos/fondos?fondo_id=".$fondo->id.'&estatus=PEN', 'url'=>"registrar/gastos"], false)!!}
                    <fieldset>
                        <legend>Detalles de reposición</legend>
                        {!!Form::model($movimiento, ['url'=>'registrar/caja-chica/reponer'])!!}
                        <div class="row">
                            {!!Form::simple('referencia', 4)!!}
                            {!!Form::simple('cuenta_id', 4)!!}
                            {!!Form::simple2($fondo, 'monto_reponer', 4)!!}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning"><i class="fa fa-undo"></i> Reponer caja chica</button>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </fieldset>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection