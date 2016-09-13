@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>{{$proponente}} ha hecho una nueva propuesta en aconcloud</h4>
    <div>
        <p>La propuesta realizada se titula: {{$titulo}}</p>
        <p>La misma tendra una fecha tope de discusi&oacute;n de {{$fecha_cierre->format('d/m/Y')}},
            durante este tiempo puedes hacer comentarios, proponer cambios, etc.</p>
        <p>Una vez finalizada la propuesta comenzara el proceso de votaci&oacute;n de la misma</p>
    </div>
    <p>
        Ingresa al siguiente link para que veas la propuesta en detalle
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/propuestas/propuestas/'.$id, 'Ver la propuesta', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection