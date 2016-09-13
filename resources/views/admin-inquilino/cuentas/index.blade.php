@extends('admin-inquilino.cuentas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Listado de cuentas'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\Cuenta', $columns, true, true, true, true)!!}
    </div>
@endsection