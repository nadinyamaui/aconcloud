@extends('admin-inquilino.viviendas.layout')
@section('contenido2')
    @if($vivienda->id)
        @include('templates.panel-header', ['titulo'=>'Modificar la vivienda'])
    @else
        @include('templates.panel-header', ['titulo'=>'Registrar una vivienda'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($vivienda, ['url'=>'admin-inquilino/viviendas'])!!}
        @include('admin-inquilino/viviendas/_form')
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection