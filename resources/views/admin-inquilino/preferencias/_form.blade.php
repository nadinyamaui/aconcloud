<div class="row">
    {!!Form::simple('dia_corte_recibo', 4)!!}
    {!!Form::simple('ano_inicio', 4)!!}
    {!!Form::simple('mes_inicio', 4, 'select', [], $meses)!!}
</div>
<div class="row">
    {!!Form::simple('porcentaje_morosidad', 4)!!}
    {!!Form::simple('inicio_morosidad', 4)!!}
</div>
<div class="row">
    {!! Form::simple('nota_en_recibo', 6, 'textarea', ['class' => 'ckeditor ']) !!}
</div>
{!!Form::submitBt()!!}
