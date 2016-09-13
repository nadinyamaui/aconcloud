@extends('admin.ayudas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de Ayudas/ Tutoriales'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\Ayuda', $columns)!!}
    </div>
@endsection