@extends('admin-inquilino.cuentas.layout')
@section('contenido2')
    @if($cuenta->id)
        @include('templates.panel-header', ['titulo'=>'Modificar la Cuenta'])
    @else
        @include('templates.panel-header', ['titulo'=>'Registrar una Cuenta'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($cuenta, ['url'=>'admin-inquilino/cuentas'])!!}
        @include('admin-inquilino.cuentas._form')
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection