@extends('admin.inquilinos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de inquilinos'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\Inquilino', $columns)!!}
    </div>
@endsection