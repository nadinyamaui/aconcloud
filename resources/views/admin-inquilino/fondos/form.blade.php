@extends('admin-inquilino.fondos.layout')
@section('contenido2')
    @if($fondo->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el fondo'])
    @else
        @include('templates.panel-header', ['titulo'=>'Registrar un nuevo fondo'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($fondo, ['url'=>'admin-inquilino/fondos'])!!}
        @include('admin-inquilino.fondos._form')
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection