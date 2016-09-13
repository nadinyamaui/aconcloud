@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Fondos y Caja Chica</legend>
        <div class="row">
            <div class="col-md-12">
                {!!HTML::tableAjax('App\Models\Inquilino\Fondo', $columns, true,true,true,false,"admin-inquilino/fondos", true)!!}
            </div>
        </div>
    </fieldset>
@endsection