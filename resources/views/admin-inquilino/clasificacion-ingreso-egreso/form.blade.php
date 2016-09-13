@extends('admin-inquilino.clasificacion-ingreso-egreso.layout')
@section('contenido2')
    @if($clasificacion->id)
        @include('templates.panel-header', ['titulo'=>'Modificar la Clasificación'])
    @else
        @include('templates.panel-header', ['titulo'=>'Registrar una Clasificación'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($clasificacion, ['url'=>'admin-inquilino/clasificacion-ingreso-egreso'])!!}
        @include('admin-inquilino.clasificacion-ingreso-egreso._form')
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection