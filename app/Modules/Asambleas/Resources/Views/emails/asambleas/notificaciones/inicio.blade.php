@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$destinatario}}</h3>
    <hr />
    <h4>Te escribimos para notificarte que ya esta por dar inicio la asamblea</h4>
    <div>
        <p>La asamblea se titula: {{$titulo}}</p>
    </div>
    @if($esta_retrasada)
        <div>
            <p>
                Te recordamos que eres el moderador de esta asamblea y la misma ya comenzo y aun no esta configurado el evento.
                Te recomendamos darte prisa en crear el evento en youtube y configurarlo en el sistema
            </p>
            <p>
                Si tienes dudas de como crear el evento puedes visitar la secci&oacute;n de {!! link_to('ayudas', 'ayudas') !!} para obtener mas informaci&oacute;n
            </p>
        </div>
    @else
        <p>
            Ingresa al siguiente link para que des como iniciada la asamblea y los vecinos sean notificados
        </p>
        <table>
            <tr>
                <td class="padding">
                    <p>{!!link_to('modulos/asambleas/asambleas/'.$id.'/comenzar', 'Dar inicio a la asamblea', ['class'=>'btn-primary'])!!}</p>
                </td>
            </tr>
        </table>
    @endif
@endsection