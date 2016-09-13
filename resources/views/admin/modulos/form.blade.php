@extends('admin.modulos.layout')
@section('contenido2')
    @if($modulo->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Módulo'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un nuevo Módulo'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($modulo, ['url'=>'admin/modulos'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('codigo', 4)!!}
            {!!Form::simple('nombre', 4)!!}
            {!!Form::simple('costo_mensual', 4)!!}
        </div>
        <div class="row">
            {!!Form::simple('descripcion', 12, "textarea")!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection