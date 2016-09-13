@extends('admin-inquilino.tipo-viviendas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de tipos de vivienda'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\TipoVivienda', $columns, false, true, false)!!}
    </div>
@endsection