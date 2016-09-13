@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}. Buenos dias!</h3>
    <hr />
    <h4>Te escribimos para notificarte que hoy hay una asamblea en tu condominio</h4>
    <div>
        <p>La asamblea se titula: {{$titulo}}</p>
        <p>La misma comenzar&aacute; a las {{$hora_inicio}} y durará hasta las {{$hora_fin}}.</p>
        <p>Te notificaremos 30 minutos antes del inicio de la asamblea</p>
    </div>
    @if($es_autor)
        <div>
            <p>Te recordamos que eres el moderador de esta asamblea, recuerda que debes preparar el evento en youtube</p>
            <p>Si tienes dudas de como crear el evento puedes visitar la secci&oacute;n de {!! link_to('ayudas', 'ayudas') !!} para obtener mas informaci&oacute;n</p>
        </div>
    @endif
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