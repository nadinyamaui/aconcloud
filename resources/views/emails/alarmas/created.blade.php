@extends('emails.layouts.system')
@section('contenido')
    <h3>Hola {{$nombre}}</h3>
    <hr />
    <h4>Se ha registrado una nueva alarma, los detalles se muestran a continuaci&oacute;n</h4>
    <ul>
        @if($alarma->nombre)
            <li>{!!Form::displaySimple($alarma, 'nombre')!!}</li>
        @endif
        @if($alarma->descripcion)
            <li>{!!Form::displaySimple($alarma, 'descripcion')!!}</li>
        @endif
        @if($alarma->fecha_vencimiento)
            <li>{!!Form::displaySimple($alarma, 'fecha_vencimiento')!!}</li>
        @endif
    </ul>
@endsection