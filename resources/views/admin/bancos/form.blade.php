@extends('admin.bancos.layout')
@section('contenido2')
    @if($banco->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Banco'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un nuevo Banco'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($banco, ['url'=>'admin/bancos'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('nombre', 12)!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection