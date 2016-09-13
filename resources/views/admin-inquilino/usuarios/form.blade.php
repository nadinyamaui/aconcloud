@extends('admin-inquilino.usuarios.layout')
@section('contenido2')
    @if($usuario->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Usuario'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un nuevo Usuario'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($usuario, ['url'=>'admin-inquilino/usuarios'])!!}
        @include('admin-inquilino.usuarios._form')
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/admin/usuarios/form.js')!!}
@endsection