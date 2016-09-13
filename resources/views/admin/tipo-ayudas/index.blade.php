@extends('admin.ayudas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de Tipos de ayuda'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\TipoAyuda', $columns)!!}
    </div>
@endsection