@extends('auth.layout')
@section('titulo')
    T&eacute;rminos y condiciones de uso de aconcloud para el Cliente ({{$inquilino->nombre}})
@endsection
@section('contenido')
    <div style="padding-left: 8%;padding-right: 8%;">
        <div class="login login-v2" data-pageload-addclass="animated flipInX" style="width: 100%;">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> Aconcloud

                    <small>T&eacute;rminos y condiciones de uso de aconcloud para el Cliente <strong>({{$inquilino->nombre}})</strong></small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content" style="width: 100%;font-size: 14px;color: white;">
                <h2 style="text-align: center;color: white;"><strong>T&eacute;rminos y condiciones de uso</strong></h2>

                <p style="text-align: justify;">Aconcloud se reserva el derecho de actualizar y cambiar los t&eacute;rminos y condiciones de uso sin previo aviso. Cualquier nueva funcionalidad o cambio que extienda el servicio actual, incluyendo el lanzamiento de nuevas herramientas y recursos est&aacute; bajo los t&eacute;rminos y condiciones. El uso del servicio luego de estos cambios implica que el usuario esta consiente de los mismos y est&aacute; de acuerdo.</p>
                <ol>
                    <li style="text-align: justify;">El uso de este servicio es bajo su propio riesgo. Este servicio es prestado &ldquo;tal cual&rdquo; y seg&uacute;n est&eacute; disponible</li>
                    <li style="text-align: justify;">El soporte t&eacute;cnico es provisto solo a los titulares y responsables del sistema</li>
                    <li style="text-align: justify;">Usted entiende que Aconcloud usa aplicaciones de terceros y socios para los recursos necesarios como hardware, software, redes, almacenamiento y la tecnolog&iacute;a requerida para ejecutar el servicio</li>
                    <li style="text-align: justify;">Usted est&aacute; de acuerdo en no reproducir, duplicar, copiar, vender, revender o extraer ninguna parte del servicio o acceso al servicio, sin un permiso explicito por parte de Aconcloud.</li>
                    <li style="text-align: justify;">Usted no debe usar Aconcloud para cargar, publicar, o transmitir correo electr&oacute;nico no solicitado, SMS o mensajes de &quot;spam&quot;.</li>
                    <li style="text-align: justify;">Usted no debe usar Aconcloud para transmitir ning&uacute;n gusano, virus o cualquier c&oacute;digo de naturaleza destructiva</li>
                    <li style="text-align: justify;">Aconcloud NO garantiza que el servicio no ser&aacute; interrumpido. Aconcloud har&aacute; el esfuerzo necesario para mantener la disponibilidad de la aplicaci&oacute;n en un 99% por a&ntilde;o.</li>
                    <li style="text-align: justify;">Usted entiende y acepta expresamente que Aconcloud no ser&aacute; responsable de ning&uacute;n da&ntilde;o directo, indirecto, incidental, especial o ejemplar, incluyendo pero no limitado a, da&ntilde;os por p&eacute;rdida de informaci&oacute;n, uso, datos u otras p&eacute;rdidas intangibles ( incluso si Aconcloud ha sido advertido de la posibilidad de tales da&ntilde;os ), resultantes de: ( i ) el uso o la imposibilidad de utilizar el servicio; ( ii ) el acceso no autorizado o alteraci&oacute;n de sus transmisiones o datos; ( iii ) declaraciones o conducta de terceros en el servicio ; ( iv ) o cualquier otra cuesti&oacute;n relacionada con el servicio</li>
                    <li style="text-align: justify;">Aconcloud no se hace responsable por cualquier contenido que sea registrado, difundido, cargado o distribuido a trav&eacute;s de Aconcloud</li>
                    <li style="text-align: justify;">Aconcloud no se hace responsable por las decisiones que tomen los miembros de la junta de condominio, basadas en los reportes que genere el sistema</li>
                    <li style="text-align: justify;">Cualquier reporte, grafico, datos estad&iacute;sticos, c&aacute;lculos o recibos generados por Aconcloud NO TIENEN NINGUNA VALIDEZ LEGAL, a menos que esto sea expresado textualmente y cumpla la legislaci&oacute;n vigente.</li>
                    <li style="text-align: justify;">Es responsabilidad de los usuarios darle validez legal a cualquier reporte, grafico, datos estad&iacute;sticos, c&aacute;lculos o recibos.</li>
                    <li style="text-align: justify;">Las pol&iacute;ticas de respaldo de la aplicaci&oacute;n son las siguientes: Lunes, Mi&eacute;rcoles y Viernes a las 8:00 son respaldados y guardados los archivos del usuario en una cuenta de propiedad de Aconcloud en Dropbox. Adicionalmente se realiza un respaldo de la base de datos cada hora, todos los d&iacute;as, entre el horario de 7:00 hasta las 22:00 y son almacenados como archivos comprimidos SIN ENCRIPTAR en una cuenta en Dropbox de propiedad de Aconcloud. Aconcloud mantendr&aacute; como m&aacute;ximo 30 d&iacute;as continuos de respaldo. Aconcloud no se hace responsable por perdida de informaci&oacute;n que no pueda ser recuperada por las pol&iacute;ticas de respaldo actuales, sin importar la causa ni la responsabilidad de la misma.</li>
                    <li style="text-align: justify;">Cualquier m&oacute;dulo desarrollado por Aconcloud se rige por los t&eacute;rminos y condiciones detallados anteriormente</li>
                </ol>

                <form method="post" action="{{url('terminos-condiciones')}}">
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Acepto los terminos y condiciones de uso</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
    </div>
@endsection