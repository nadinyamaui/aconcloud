@extends('auth.layout')
@section('titulo')
    Registro en aconcloud ({{$inquilino->nombre}})
@endsection
@section('contenido')
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated flipInX" style="width: 66%;">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> Aconcloud
                <small>El mejor sistema de autogestión de condominios</small>
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
        </div>
        <!-- end brand -->
        <div class="login-content" style="width: 100%;">
            @include('templates.mensaje')
            {!!Form::model($usuario, ['open'=>'auth/registro','class'=>'margin-bottom-0'])!!}
            {!!Form::hidden('id')!!}
            {!!Form::hidden('grupo_id', 3)!!}
            <div class="note note-info">
                <p>¡Hola! Bienvenido a tu condominio, a partir de ahora todas
                    las cosas relacionadas con tu condominio deberas hacerlas por aqui,
                    completa tus datos para que la junta de condominio pueda continuar con la configuración del sistema
                </p>
            </div>
            <div class="row">
                {!!Form::simple('nombre', 6)!!}
                {!!Form::simple('apellido', 6)!!}
            </div>
            <div class="row">
                {!!Form::simple('email')!!}
            </div>
            <div class="row">
                {!!Form::simple('password', 6, 'password')!!}
                {!!Form::simple('password_confirmation', 6, 'password')!!}
            </div>
            <div class="row">
                {!!Form::simple2($vivienda, 'tipo_vivienda_id', 6)!!}
                {!!Form::simple2($vivienda, 'numero_apartamento', 6)!!}
            </div>
            <div class="row">
                {!!Form::simple2($vivienda,'piso', 6)!!}
                {!!Form::simple2($vivienda,'torre', 6)!!}
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-success btn-block btn-lg">Registrarme</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    <!-- end login -->
@endsection