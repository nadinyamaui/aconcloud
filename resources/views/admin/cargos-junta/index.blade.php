@extends('admin.cargos-junta.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de cargos de la junta'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\CargoJunta', $columns)!!}
    </div>
@endsection