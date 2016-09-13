@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr/>
    <h4>Se ha activado el proceso de votaci&oacute;n en la propuesta {{$titulo}}</h4>
    <div>
        <p>El usuario {{$activador}} ha activado el proceso de votaci&oacute;n.</p>
    </div>
    <p>
        Ingresa al siguiente link para que puedas ejercer tu derecho al voto!
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/propuestas/propuestas/'.$id.'/votaciones/votar', 'Votar', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection