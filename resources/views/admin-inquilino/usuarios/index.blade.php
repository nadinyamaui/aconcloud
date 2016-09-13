@extends('admin-inquilino.usuarios.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de Usuarios en tu edificio'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\User', $columns)!!}
    </div>
@endsection