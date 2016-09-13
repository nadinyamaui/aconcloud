{!!Form::hidden('id')!!}
<div class="row">
    {!!Form::simple('nombre', 4)!!}
    {!!Form::simple('apellido', 4)!!}
    {!!Form::simple('cedula', 4)!!}
</div>
<div class="row">
    {!!Form::simple('email', 3)!!}
    {!!Form::simple2($rol, 'grupo_id', 3)!!}
    @if($usuario->exists)
        {!!Form::simple('password', 3, 'password')!!}
        {!!Form::simple('password_confirmation', 3, 'password')!!}
    @else
        <div class="col-md-6">
            <p>La contraseña por defecto es aconcloud, cuando se inicie sesión por primera vez se le pedirá
                al usuario que cambie su clave</p>
        </div>
        {!!Form::hidden('password', 'aconcloud')!!}
        {!!Form::hidden('password_confirmation', 'aconcloud')!!}
    @endif
</div>
<div class="row">
    {!!Form::simple2($usuario, 'ind_activo', 4)!!}
    {!!Form::simple('telefono_celular', 4)!!}
    {!!Form::simple('telefono_otro', 4)!!}
</div>
<div class="row">
    {!!Form::simple('ind_recibir_gastos_creados', 3)!!}
    {!!Form::simple('ind_recibir_gastos_modificados', 3)!!}
    {!!Form::simple('ind_recibir_ingresos_creados', 3)!!}
    {!!Form::simple('ind_recibir_ingresos_modificados', 3)!!}
</div>
<div class="row">
    {!!Form::simple('ind_autenticacion_en_dos_pasos', 3)!!}
</div>