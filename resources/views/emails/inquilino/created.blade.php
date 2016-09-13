@extends('emails.layouts.system')

@section('contenido')
    <h3>¡Hola! Bienvenido a aconcloud</h3>
    <hr />
    <p>
        Primero que nada te damos la bienvenida al mejor sistema de autogesti&oacute;n de condominios,
        pronto veras que manejar tu condominio es mas sencillo de lo que piensas.
    </p>
    <p>
        Ingresa al siguiente link para que puedas empezar a configurar tu condominio
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="{{$host}}" class="btn-primary">Acceder a mi condominio</a></p>
            </td>
        </tr>
    </table>
@endsection