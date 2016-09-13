@extends('emails.layouts.system')
@section('contenido')
    <h3>Hola</h3>
    <hr />
    <h4>Haz click en el link para cambiar tu contraseña</h4>
    <table>
        <tr>
            <td class="padding">
                <p>{!!link_to('password/reset/'.$token, 'Cambiar contraseña')!!}</p>
            </td>
        </tr>
    </table>
@endsection