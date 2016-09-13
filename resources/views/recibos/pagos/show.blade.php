@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Consultas</a></li>
        <li><a href="#">Pagos</a></li>
        <li class="active">Ver</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Consulta de pagos <small>Aqui puedes ver un detalle de los pagos de tu condominio </small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Detalles del pago'])
                <div class="panel-body">
                    @include('templates.errores')
                    <fieldset>
                        <legend>Detalles del pago</legend>
                        <div class="row">
                            {!!Form::display($pago, 'vivienda->nombre', 3)!!}
                            {!!Form::display($pago,'monto_pagado', 3)!!}
                            {!!Form::display($pago,'total_relacion', 3)!!}
                            {!!Form::display($pago,'estatus_display', 3)!!}
                        </div>
                        <div class="row">
                            {!!Form::display($pago->movimientoCuenta, 'cuenta->nombre', 3)!!}
                            {!!Form::display($pago->movimientoCuenta, 'referencia', 3)!!}
                            {!!Form::display($pago->movimientoCuenta, 'comentarios', 3)!!}
                            {!!Form::display($pago->movimientoCuenta, 'descripcion', 3)!!}
                        </div>
                        @if($pago->recibos->count()>0)
                            <h4>Recibos</h4>
                            {!!HTML::customTable($pago->recibos,'App\Models\Inquilino\Recibo', $columns)!!}
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{url('consultas/pagos')}}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Volver</a>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
@endsection