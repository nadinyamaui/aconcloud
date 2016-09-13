<ul>
    <li>{!!Form::displaySimple($gasto, 'clasificacion->nombre')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'fecha_factura')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'numero_factura')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'monto_egreso')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'forma_pago')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'referencia')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'cuenta->nombre')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'fondo->nombre')!!}</li>
    <li>{!!Form::displaySimple($gasto, 'comentarios')!!}</li>
    @if($gasto->ind_movimiento_en_cuotas)
        <li>{!!Form::displaySimple($gasto, 'ind_movimiento_en_cuotas')!!}</li>
        <li>{!!Form::displaySimple($gasto, 'cuota_numero')!!}</li>
        <li>{!!Form::displaySimple($gasto, 'total_cuotas')!!}</li>
    @endif
</ul>