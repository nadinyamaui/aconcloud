@extends('admin-inquilino.tipo-viviendas.layout')
@section('contenido2')
    @if($tipo->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Tipo de vivienda'])
    @else
        @include('templates.panel-header', ['titulo'=>'Registrar un Tipo de vivienda'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($tipo, ['url'=>'admin-inquilino/tipo-viviendas'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('nombre', 12)!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection