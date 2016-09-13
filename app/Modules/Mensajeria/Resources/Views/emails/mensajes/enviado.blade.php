@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$nombre}}</h3>
    <hr />
    <h4>{{$nombreRemitente}} te ha enviado un mensaje directo en aconcloud</h4>
    <div>
        {!!$cuerpo!!}
    </div>
    <p>
        Ingresa al siguiente link para que veas mas detalles del mensaje
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/mensajeria/mensajes/'.$id, 'Ver el mensaje', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection