@extends('emails.layouts.system')
@section('contenido')
    <h3>Hola {{$nombre}}</h3>
    <hr />
    <p>
        Aconcloud te informa que presentas una deuda vencida de Bs. {{App\Helpers\Helper::tm($recibo->vivienda->saldo_deudor)}}
    </p>
    <p>
        Para visualizar el detalle de esta deuda ingresa en {{$inquilino->host}} en la opci&oacute;n consulta de recibos.
    </p>
    <p>
        Recuerda que puedes ir realizando abonos de saldo a tu vivienda y que el pagar a tiempo, evita tener recargos adicionales por intereses moratorios.
    </p>
    <p>
        Te esperamos en {{$inquilino->host}}
    </p>
@endsection