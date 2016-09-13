@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>&iquest;Por qu&eacute; aun no has ejercido tu derecho al voto?</h4>
    <div>
        <p>Aun no has ejercido tu derecho al voto, te recordamos que tu voto es muy importante para nuestra comunidad, no te tomar&aacute; mas de 5 minutos votar</p>
        <p>Si tienes dudas acerca del proceso, puedes contactar a los administradores de tu junta de condominio, que te podran explicar como funciona este proceso</p>
    </div>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/propuestas/propuestas/'.$id, 'Ver la propuesta', ['class'=>'btn-primary'])!!}</p>
                <p>{!!link_to('modulos/propuestas/propuestas/'.$id.'/votaciones/votar', 'Votar', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection