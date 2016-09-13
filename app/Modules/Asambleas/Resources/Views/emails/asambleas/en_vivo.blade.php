@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>&iexcl;Estamos en vivo!</h4>
    <div>
        <p>La asamblea {{$titulo}}</p>
        <p>Ya ha comenzado y estamos en vivo, no pierdas tiempo y has click en Ver la asamblea en vivo para que estés
            al tanto y puedas intervenir en todos los puntos a discutir en esta asamblea</p>
    </div>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/asambleas/asambleas/'.$id, 'Ver la asamblea en vivo', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection