@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Clasificaciones de gastos e ingresos</legend>
        <div class="row">
            <div class="col-md-12">
                {!!HTML::tableAjax('App\Models\Inquilino\ClasificacionIngresoEgreso',  $columns, true,true,true,false,"admin-inquilino/clasificacion-ingreso-egreso", true)!!}
            </div>
        </div>
    </fieldset>
@endsection