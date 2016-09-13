@extends('auth.layout')
@section('titulo')
    Recuperar contraseña ({{$inquilinoActivo->nombre}})
@endsection
@section('contenido')
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated flipInX">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> {{$inquilinoActivo->nombre}}
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
        </div>
        <!-- end brand -->
        <div class="login-content">
            @include('templates.mensaje')
            @if (session('status'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('status') }}
                </div>
            @endif
            {!!Form::open(['open'=>'password/reset','class'=>'margin-bottom-0'])!!}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group m-b-20">
                <input type="text" class="form-control input-lg" placeholder="Correo" name="email" value="{{ old('email') }}"/>
            </div>
            <div class="form-group m-b-20">
                <input type="password" class="form-control input-lg" placeholder="Nueva Contraseña" name="password"/>
            </div>
            <div class="form-group m-b-20">
                <input type="password" class="form-control input-lg" placeholder="Confirmación de la contraseña" name="password_confirmation"/>
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-success btn-block btn-lg">Cambiar contraseña</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    <!-- end login -->
@endsection