@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Registrar</a></li>
        <li><a href="#">Gastos</a></li>
        <li class="active">Nuevo</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Registro de gastos <small>Aqui puedes registrar los gastos comunes y no comunes en tu condominio </small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @yield('contenido2')
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection