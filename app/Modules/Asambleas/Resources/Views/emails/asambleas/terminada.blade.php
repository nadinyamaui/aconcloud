@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>La asamblea {{$titulo}} ha culminado</h4>
    <div>
        <p>Durante la asamblea se discutieron las siguientes propuestas:</p>
        <ul>
            @foreach($propuestas as $propuesta)
                <li>{!! link_to('modulos/propuestas/propuestas/'.$propuesta->id, $propuesta->titulo) !!} </li>
            @endforeach
        </ul>
    </div>
    <p>
        Si deseas volver a ver la asamblea puedes hacerlo a traves del siguiente link
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/asambleas/asambleas/'.$id, 'Ver la asamblea', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection