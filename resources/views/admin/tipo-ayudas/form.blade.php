@extends('admin.ayudas.layout')
@section('contenido2')
    @if($tipo->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el tipo de ayuda'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un tipo de ayuda'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($tipo, ['url'=>'admin/tipo-ayudas'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('nombre', 12)!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection