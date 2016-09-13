@extends('emails.layouts.system')

@section('contenido')
    <h3>Hola {{$usuario->nombre_completo}}. Bienvenido a aconcloud</h3>
    <hr />
    <p>
        Primero que nada te damos la bienvenida al mejor sistema de autogesti&oacute;n de condominios,
        te notificamos que la junta de condominio tomo la mejor decisi&oacute;n durante su gesti&oacute;n,
        el administrador de la junta de condominio te registr&oacute; en aconcloud
    </p>
    <p>
        Para poder acceder a tu cuenta deberas hacerlo con tu correo electr&oacute;nico ({{$usuario->email}}),
        tu contraseña es aconcloud, el sistema te pedira que la cambies cuando inicies sesi&oacute;n.<br>
        Por &uacute;ltimo aqui abajo te dejo el link para que entres a lo que sera tu nueva plataforma
        donde podras ver todo lo relacionado con tu condominio
    </p>
    <table>
        <tr>
            <td class="padding">
                <p><a href="http://{{$host}}" class="btn-primary">Acceder a mi condominio</a></p>
            </td>
        </tr>
    </table>
@endsection