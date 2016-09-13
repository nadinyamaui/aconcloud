@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Cuentas bancarias. Ingrese todas tus cuentas bancarias</legend>
        <div class="row">
            <div class="col-md-12">
                {!!HTML::tableAjax('App\Models\Inquilino\Cuenta', $columns, true,true,true,false,"admin-inquilino/cuentas", true)!!}
            </div>
        </div>
    </fieldset>
@endsection