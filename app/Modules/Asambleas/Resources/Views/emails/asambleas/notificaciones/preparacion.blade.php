@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>Te escribimos para notificarte que en menos de 30 minutos dará inicio la asamblea.</h4>
    <div>
        <p>La asamblea se titula: {{$titulo}}</p>
        <p>La misma comenzará a las {{$hora_inicio}} y durará hasta las {{$hora_fin}}.</p>
        <p>
            Si no puedes asistir presencialmente a la asamblea, no te preocupes puedes verla desde donde estés utilizando cualquier equipo con acceso a internet.
        </p>
    </div>
    @if($es_autor)
        @if($esta_retrasada)
            <div>
                <p>
                    Te recordamos que eres el moderador de esta asamblea y dara inicio en 30 minutos por lo que debes apresurarte, aun la asamblea no esta completamente configurada.
                    Todavia debes crear el evento en youtube y colocar el link del evento en el sistema para que los residentes
                    puedan ver la asamblea en linea
                </p>
                <p>
                    Si tienes dudas de como crear el evento puedes visitar la secci&oacute;n de {!! link_to('ayudas', 'ayudas') !!} para obtener mas informaci&oacute;n
                </p>
            </div>
        @else
            <div>
                <p>
                    Te recordamos que eres el moderador de esta asamblea, puedes ir preparando todo,
                    ya la asamblea esta correctamente configurada en el sistema y estamos listos para empezar
                </p>
            </div>
        @endif

    @endif
    <p>
        Para que veas los detalles de la asamblea ingresa en
    </p>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('modulos/asambleas/asambleas/'.$id, 'Ver la asamblea', ['class'=>'btn-primary'])!!}</p>
            </td>
        </tr>
    </table>
@endsection