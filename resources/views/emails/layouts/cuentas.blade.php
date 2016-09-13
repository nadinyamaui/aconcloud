<ul>
    @foreach($cuentas as $cuenta)
        <li>Cuenta {{$cuenta->nombre}} tiene un saldo actual de
            <b>{{\App\Helpers\Helper::tm($cuenta->saldo_actual)}}</b></li>
    @endforeach
    @foreach($fondos as $fondo)
        <li>Fondo {{$fondo->nombre}} tiene un saldo actual de <b>{{\App\Helpers\Helper::tm($fondo->saldo_actual)}}</b>
        </li>
    @endforeach
</ul>