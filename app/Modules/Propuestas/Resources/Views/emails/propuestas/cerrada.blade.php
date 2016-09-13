@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>Ha finalizado el proceso de votacion para la propuesta {{$titulo}}</h4>
    <div>
        <p>Gracias por tu participaci&oacute;n, a continuaci&oacute;n puedes ver un detalle de la votaci&oacute;n</p>
        <ul>
            <li>Total de votantes: {{$total_votantes}}</li>
            <li>Total de personas que no votaron: {{$total_votantes_pendientes}}</li>
            <li>Total de votantes a favor de la propuesta: {{$total_votos_a_favor}}</li>
            <li>Total de votantes en contra de la propuesta: {{$total_votos_en_contra}}</li>
        </ul>
        <div>
            <p>Una vez cerrado el proceso de votaci&oacute;n se da como</p>
            <h1>{{$decision}}</h1>
        </div>
    </div>
    <p>
        Puedes acceder al siguiente link para ver mas informaci&oacute;n de la propuesta y las votaciones
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/propuestas/propuestas/'.$id, 'Ver la propuesta', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection