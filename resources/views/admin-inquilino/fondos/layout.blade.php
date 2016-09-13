@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Administración</a></li>
        <li><a href="#">Fondos</a></li>
        <li class="active">Todos</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Fondos <small>Aqui estan los fondos de tu condominio</small></h1>
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