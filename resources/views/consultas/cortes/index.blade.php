@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Consultas</a></li>
        <li><a href="#">Corte de recibos</a></li>
        <li class="active">Todos</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Corte de recibos mensuales <small>Aqui puedes ver el detalle de los cortes mensuales de los recibos</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Listado de cortes mensuales'])
                @include('templates.mensaje')
                <div class="panel-body">
                    {!!HTML::tableAjax('App\Models\Inquilino\CorteRecibo', $columns, false, false, true, true, ["list"=>"consultas/cortes","url"=>"recibos/cortes"])!!}
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection