@extends('admin-inquilino.clasificacion-ingreso-egreso.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de clasificaciones'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\ClasificacionIngresoEgreso', $columns)!!}
    </div>
@endsection