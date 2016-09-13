@extends('admin.inquilinos.layout')
@section('contenido2')
    @if($inquilino->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Inquilino'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un nuevo Inquilino'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($inquilino, ['url'=>'admin/inquilinos'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('nombre', 4)!!}
            {!!Form::simple('host', 4)!!}
            {!!Form::multiselect('modulos', 4)!!}
        </div>
        <div class="row">
            {!!Form::simple('direccion', 4, 'textarea')!!}
            {!!Form::simple('descripcion', 4, 'textarea')!!}
            {!!Form::simple('email_administrador', 4)!!}
        </div>
        <div class="row">
            {!! Form::simple('rif', 4) !!}
        </div>
        @if($inquilino->exists)
            <div class="row">
                <div class="col-lg-12 form-group">
                    <a href="{{url('admin/inquilinos/'.$inquilino->id.'/instalar')}}" class="btn btn-primary">
                        <i class="fa fa-database"></i> Instalar inquilino
                    </a>
                </div>
            </div>
        @endif
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection