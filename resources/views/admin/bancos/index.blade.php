@extends('admin.bancos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de bancos'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\App\Banco', $columns)!!}
    </div>
@endsection