@extends('alarmas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de Alarmas'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\Alarma', $columns, false, false, false)!!}
    </div>
@endsection