@extends('emails.layouts.system')
@section('contenido')
    <h3>Hola {{$nombre}}</h3>
    <hr />
    <h4>El usuario {{$responsable}} ha registrado un nuevo gasto en tu condominio, los detalles se muestran a continuaci&oacute;n</h4>
    @include('emails.gastos.detail')
    <h4>Adicionalmente te incluimos algunos detalles sobre las cuentas y fondos en {{$inquilino->nombre}}</h4>
    @include('emails.layouts.cuentas')
@endsection