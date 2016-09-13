@extends('admin.cargos-junta.layout')
@section('contenido2')
    @if($cargo->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Cargo de la junta'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un nuevo Cargo de la junta'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($cargo, ['url'=>'admin/cargos-junta'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('nombre', 12)!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection