@extends('auth.layout')
@section('titulo')
    Nueva contraseña en ({{$inquilinoActivo->nombre}})
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
            {!!Form::open(['url'=>'auth/nuevacontrasena','class'=>'margin-bottom-0'])!!}
            <div class="note note-info">
                <p>¡Hola! Bienvenido a tu condominio, debes cambiar tu contraseña
                </p>
                <p>
                    Te recomendamos que sea una facil de recordar pero que sea segura
                </p>
            </div>
            <div class="row">
                {!!Form::simple2($user, 'password', 6, 'password')!!}
                {!!Form::simple('password_confirmation', 6, 'password')!!}
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-success btn-block btn-lg">Cambiar contraseña</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    <!-- end login -->
@endsection