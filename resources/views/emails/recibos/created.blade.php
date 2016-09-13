@extends('emails.layouts.system')
@section('contenido')
    <h3>Hola {{$nombre}}</h3>
    <hr />
    <p>
        Aconcloud te informa que fue generado el recibo correspondiente al mes de {{$mes}},
        n&uacute;mero {{$recibo->num_recibo}} por un monto de Bs. {{App\Helpers\Helper::tm($recibo->monto_total)}} para la vivienda,
        {{$recibo->vivienda->nombre}} de {{$nombreInquilino}} y vence el {{$recibo->corteRecibo->fecha_vencimiento->format('d/m/Y')}}.
    </p>
    @if($recibo->vivienda->saldo_deudor > 0)
        <p>
            Tu vivienda presenta una deuda vencida de Bs. {{App\Helpers\Helper::tm($recibo->vivienda->saldo_deudor)}}
        </p>
    @endif
    <p>
        Para visualizar tu recibo y {!!link_to('consultas/recibos/'.$recibo->id, 'haz click aqui')!!} o ingresa a {{$inquilino->host}} opci&oacute;n consulta de recibos.
    </p>
    <p>
        Recuerda pagar a tiempo; evita recargos adicionales.
        Nota: los recibos y notificaciones de cobro digitales tienen la misma validez que las impresas.
        Te esperamos en {{$inquilino->host}}
    </p>
@endsection