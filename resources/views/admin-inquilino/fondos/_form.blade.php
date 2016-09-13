{!!Form::hidden('id')!!}
<div class="row">
    {!!Form::simple('nombre', 6)!!}
    @if(!$fondo->id)
        {!!Form::simple('saldo_actual', 6)!!}
    @endif
</div>
<div class="row">
    {!!Form::simple('ind_caja_chica', 6)!!}
    {!!Form::simple('porcentaje_reserva', 6)!!}
</div>
<div class="row">
    <div id="div-monto-caja-chica">
        {!!Form::simple('monto_maximo', 6)!!}
    </div>
    {!!Form::simple('cuenta_id', 6)!!}
</div>
<div class="row">
    {!!Form::simple('ind_activo', 6)!!}
</div>

