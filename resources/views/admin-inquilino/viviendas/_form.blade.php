{!!Form::hidden('id')!!}
<div class="row">
    {!!Form::simple('numero_apartamento', 4)!!}
    {!!Form::simple('piso', 4)!!}
    {!!Form::simple('torre', 4)!!}
</div>
<div class="row">
    @if($inquilinoActivo->ind_configurado)
        {!!Form::display($vivienda, 'saldo_a_favor', 4)!!}
        {!!Form::display($vivienda, 'saldo_deudor', 4)!!}
    @else
        {!!Form::simple('saldo_a_favor', 4)!!}
        {!!Form::simple('saldo_deudor', 4)!!}
    @endif
    {!!Form::simple('propietario_id', 4, 'select', [], $usuarios)!!}
</div>
<div class="row">
    {!!Form::multiselect('usuarios', 4)!!}
    {!!Form::simple('comentarios', 8,'textarea')!!}
</div>