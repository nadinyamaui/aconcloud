@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>Gracias por ejercer tu derecho al voto, a continuaci&oacute;n puedes ver un detalle de tu voto</h4>
    <div>
        <ul>
            @if($voto->ind_en_acuerdo)
                <li>Estuviste <strong>de acuerdo</strong> con la propuesta</li>
            @else
                <li>Estuviste <strong>en desacuerdo</strong> con la propuesta</li>
            @endif
            <li>Tus comentarios fueron: {{$voto->comentarios}}</li>
        </ul>
    </div>
    <p>
        Si lo deseas puedes volver a ver la propuesta, recuerda que no puedes modificar tu voto.
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/propuestas/propuestas/'.$id, 'Ver la propuesta', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection