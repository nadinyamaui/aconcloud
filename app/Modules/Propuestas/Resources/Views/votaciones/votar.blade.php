@extends('propuestas::propuestas.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Ejercer mi derecho al voto'])
    <div class="panel-body">
        @include('templates.errores')
        <div class="row">
            <div class="col-md-4">
                <div class="note note-danger">
                    <h4>
                        <div id="tiempo_restante">

                        </div>
                    </h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="note note-success">
                    <h4>Informaci&oacute;n importante sobre tu voto</h4>
                    <ul>
                        <li>Estas votando como: <strong>{{$usuario->nombre_completo}}</strong></li>
                        <li>Estas votando como residente de la vivienda: <strong>{{$voto->vivienda->nombre}}</strong></li>
                        <li>Estas votando por la propuesta: <strong>{{$propuesta->titulo}}</strong></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="note note-warning">
                    <h4>Importante</h4>
                    <p>
                        Recuerda que podras votar una sola vez y una vez confirmado tu voto no podras cambiar de opinion.<br>
                        Una vez ejercido tu derecho al voto podras descargar un certificado de votaci&oacute;n con el que podras confirmar tu elecci&oacute;n.<br>
                        Al finalizar el proceso de votaci&oacute;n se te enviara un correo electr&oacute;nico con el resultado de los votos y la decisi&oacute;n final
                    </p>
                </div>
            </div>
        </div>
        {!!Form::model($voto, ['url'=>'modulos/propuestas/propuestas/'.$propuesta->id.'/votaciones/votar', 'dont_create_url'=>true])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!! Form::simple('ind_en_acuerdo', 3) !!}
            {!! Form::simple('comentarios', 9, 'textarea') !!}
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Votar</button>

                <a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id)}}" class="btn btn-primary"><i class="fa fa-backward"></i> Volver a la propuesta</a>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
    <script type="text/javascript">
        setTimeout(function() { window.location = baseUrl+"modulos/propuestas/propuestas/{{$propuesta->id}}/votaciones"; }, 30000);

        var timeLeft = 30;
        var elem = document.getElementById('tiempo_restante');

        var timerId = setInterval(countdown, 1000);

        function countdown() {
            if (timeLeft == 0) {
                clearTimeout(timerId);
                doSomething();
            } else {
                elem.innerHTML = 'Tiempo restante para ejercer tu derecho al voto <b>'+timeLeft+'</b> segundos';
                timeLeft--;
            }
        }
    </script>
@endsection