@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Modulos</a></li>
        <li><a href="#">Asambleas</a></li>
        <li class="active">Ver</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
<h1 class="page-header">Asambleas vecinales
    <small>aqui puedes ver todas las asambleas que se han hecho en tu asociación de vecinos.</small>
</h1>
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