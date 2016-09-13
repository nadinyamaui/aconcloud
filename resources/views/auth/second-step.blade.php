@extends('auth.layout')
@section('titulo')
    Verifica tu inicio de sesión en ({{$inquilinoActivo->nombre}})
@endsection
@section('contenido')
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated flipInX">
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
        <div class="login-content">
            @include('templates.mensaje')
            {!!Form::open(['url'=>'auth/second-step', 'class'=>'margin-bottom-0'])!!}
            <div class="note note-info">
                <p>
                    Verifica tu inicio de sesión, ingresa el código que recibiste en tu teléfono
                </p>
            </div>
            <div class="row">
                {!!Form::simple2($user, 'token_autenticacion_en_dos_pasos', 12)!!}
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-success btn-block btn-lg">Verificar inicio de sesión</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    <!-- end login -->
@endsection