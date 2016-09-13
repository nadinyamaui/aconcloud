@extends('admin-inquilino.fondos.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de fondos de tu condominio'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\Fondo',$columns, true, true, true, true)!!}
    </div>
@endsection