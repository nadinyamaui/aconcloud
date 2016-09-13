@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Viviendas en tu edificio</legend>
        <div class="row">
            <div class="col-md-12">
                <div class="note note-info">
                    <p><b>¡Psst!.</b> Tal como te dijimos puedes enviar un link a todos los propietarios de tu edificio para que ellos mismos se registren.</p>
                    <a class="btn btn-success abrir-modal" href="{{url('admin-inquilino/configurar/generar-token')}}"><i class="fa fa-envelope"> Permitir que los usuarios puedan registrarse</i></a>
                </div>
                {!!HTML::tableAjax('App\Models\Inquilino\Vivienda', $columns, false,true,false,false,"admin-inquilino/viviendas", true)!!}
            </div>
        </div>
    </fieldset>
@endsection