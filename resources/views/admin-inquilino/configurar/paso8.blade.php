@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Ultimos detalles</legend>
        <div class="row">
            <div class="col-md-12">
                {!!Form::model($preferencia, ['url'=>'admin-inquilino/configurar/paso8'])!!}
                @include('admin-inquilino.preferencias._form')
                {!!Form::close()!!}
            </div>
        </div>
    </fieldset>
@endsection
