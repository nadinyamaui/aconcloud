@extends('admin-inquilino.viviendas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de viviendas'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\Vivienda', $columns, false, true, false)!!}
    </div>
@endsection