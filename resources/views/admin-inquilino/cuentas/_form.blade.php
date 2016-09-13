{!!Form::hidden('id')!!}
<div class="row">
    {!!Form::simple('banco_id', 6)!!}
    {!!Form::simple('numero', 6)!!}
</div>
<div class="row">
    @if(!$cuenta->id)
        {!!Form::simple('saldo_actual', 6)!!}
    @endif
    {!!Form::simple('ind_activa', 6)!!}
</div>