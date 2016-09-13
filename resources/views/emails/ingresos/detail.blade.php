<ul>
    <li>{!!Form::displaySimple($ingreso, 'clasificacion->nombre')!!}</li>
    <li>{!!Form::displaySimple($ingreso, 'fecha_factura')!!}</li>
    <li>{!!Form::displaySimple($ingreso, 'numero_factura')!!}</li>
    <li>{!!Form::displaySimple($ingreso, 'monto_ingreso')!!}</li>
    <li>{!!Form::displaySimple($ingreso, 'referencia')!!}</li>
    <li>{!!Form::displaySimple($ingreso, 'cuenta->nombre')!!}</li>
    <li>{!!Form::displaySimple($ingreso, 'comentarios')!!}</li>
    @if($ingreso->ind_movimiento_en_cuotas)
        <li>{!!Form::displaySimple($ingreso, 'ind_movimiento_en_cuotas')!!}</li>
        <li>{!!Form::displaySimple($ingreso, 'cuota_numero')!!}</li>
        <li>{!!Form::displaySimple($ingreso, 'total_cuotas')!!}</li>
    @endif
</ul>