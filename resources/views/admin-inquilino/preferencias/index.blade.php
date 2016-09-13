@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Administración</a></li>
        <li><a href="#">Preferencias</a></li>
        <li class="active">Todos</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Preferencias del sistema <small>Aqui configuras algunas cosas adicionales de tu condominio</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Preferencias'])
                <div class="panel-body">
                    @include('templates.mensaje')
                    {!!Form::model($preferencia, ['url'=>'admin-inquilino/preferencias'])!!}
                    @include('admin-inquilino.preferencias._form')
                    {!!Form::close()!!}
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection
@section('javascript')
    <script src="{{ url('js/ckeditor-lite/ckeditor.js')  }}"></script>
@endsection