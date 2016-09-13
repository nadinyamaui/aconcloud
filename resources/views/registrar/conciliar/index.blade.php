@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Registrar</a></li>
        <li><a href="#">Conciliar</a></li>
        <li class="active">Inicio</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Conciliación <small>Aqui puedes conciliar los movimientos pendientes en tu condominio</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        @include('templates.mensaje')
        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Ingresos/ Egresos'])
                <div class="panel-body">
                    {!!HTML::customTable($ingresosEgresos, 'App\Models\Inquilino\MovimientosCuenta', $columnasIngresoEgreso, "ingresos-egresos")!!}
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->

        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Estado de cuenta'])
                <div class="panel-body">
                    {!!HTML::customTable($estados, 'App\Models\Inquilino\MovimientosCuenta', $columnasEstadoCuenta, "estado-cuenta")!!}
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
    </div>
    <!-- end row -->
@endsection
@section('javascript')
    {!!HTML::script('js/views/registrar/conciliar.js')!!}
@endsection