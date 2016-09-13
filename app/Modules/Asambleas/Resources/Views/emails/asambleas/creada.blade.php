@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>{{$convocador}} ha convocado una nueva asamblea</h4>
    <div>
        <p>La asamblea se titula: {{$titulo}}</p>
        <p>La misma se llevar&aacute; a cabo en la siguiente fecha {{$fecha->format('d/m/Y')}} desde las {{$hora_inicio}} hasta las {{$hora_fin}}.</p>
        <p>Te notificaremos por email 30 minutos antes de que comience la asamblea</p>
    </div>
    <div>
        <p>Durante esta asamblea se discutiran las siguientes propuestas:</p>
        <ul>
            @foreach($propuestas as $propuesta)
                <li>{!! link_to('modulos/propuestas/propuestas/'.$propuesta->id, $propuesta->titulo) !!} </li>
            @endforeach
        </ul>
    </div>
    <p>
        Ingresa al siguiente link para que veas mas detalles de la asamblea
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/asambleas/asambleas/'.$id, 'Ver la asamblea', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection