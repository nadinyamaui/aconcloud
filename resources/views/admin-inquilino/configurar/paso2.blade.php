@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Usuarios del sistema. Puedes configurarlos luego</legend>
        <div class="row">
            <div class="col-md-12">
                <div class="note note-info">
                    <p><b>¡Psst!.</b> Si lo deseas puedes habilitar una sección para que los propietarios ingresen a aconcloud y ellos mismos se registren.</p>
                    <p>Si es asi no registres los usuarios todavia y cuando llegues al paso 4 te diremos como registrarlos.</p>
                </div>
                {!!HTML::tableAjax('App\Models\App\User', $columns, true,true,true,false,"admin-inquilino/usuarios", true)!!}
            </div>
        </div>
    </fieldset>
@endsection