@extends('admin.modulos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de modulos del sistema'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\Modulo', $columns)!!}
    </div>
@endsection