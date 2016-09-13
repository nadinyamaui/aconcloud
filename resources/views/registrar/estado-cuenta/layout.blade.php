@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Registrar</a></li>
        <li><a href="#">Estado de cuenta</a></li>
        <li class="active">Inicio</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Estado de cuenta <small>Aqui puedes subir tu estado de cuenta en formato QIF...</small></h1>
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