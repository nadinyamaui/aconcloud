<div id="show-recibos">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="4" class="descripcion recibo-header">ACONCLOUD</td>
            <td class="descripcion recibo-header">N° Recibo</td>
            <td class="descripcion recibo-header">{{$recibo->num_recibo}}</td>
        </tr>
        <tr>
            <td class="descripcion">Edificio</td>
            <td colspan="3">{{$inquilino->id}} - {{$inquilino->nombre}}</td>
            <td class="descripcion">Fecha Recibo</td>
            <td>{{$corte->nombre_corto}}</td>
        </tr>
        <tr>
            <td class="descripcion">Direcci&oacute;n</td>
            <td colspan="3">{{$inquilino->direccion}}</td>
            <td class="descripcion">Vencimiento</td>
            <td>{{$corte->fecha_vencimiento->format('d/m/Y')}}</td>
        </tr>
        <tr>
            <td class="descripcion">Correo</td>
            <td colspan="3">{{ \App\Models\App\Inquilino::$current->email_administrador }}</td>
            <td class="descripcion">Rif</td>
            <td>{{ \App\Models\App\Inquilino::$current->rif }}</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td colspan="2" class="descripcion centrado">Propietario</td>
            <td class="descripcion centrado"># Apto</td>
            <td class="descripcion centrado">Torre</td>
            <td class="descripcion centrado">Tipo Apto</td>
            <td class="descripcion centrado">% Alicuota</td>
        </tr>
        <tr>
            <td class="centrado" colspan="2">{{$vivienda->propietario->nombre_completo or "Indefinido"}}</td>
            <td class="centrado">{{$vivienda->numero_apartamento}}</td>
            <td class="centrado">{{$vivienda->torre}}</td>
            <td class="centrado">{{$vivienda->tipoVivienda->nombre}}</td>
            <td class="dinero centrado">{{\App\Helpers\Helper::tm($vivienda->tipoVivienda->porcentaje_pago, 4)}}</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td class="descripcion">% Morosidad</td>
            <td class="descripcion">Saldo Deudor Anterior</td>
            <td class="descripcion">Saldo a Favor Anterior</td>
            <td class="descripcion">Gasto común del mes</td>
            <td class="descripcion">Gasto no común del mes</td>
            <td class="descripcion">Total a Pagar</td>
        </tr>
        <tr>
            <td class="dinero centrado">{{ \App\Helpers\Helper::tm($recibo->porcentaje_mora) }}</td>
            <td class="dinero centrado">{{ \App\Helpers\Helper::tm($recibo->saldo_deudor) }}</td>
            <td class="dinero centrado">{{ \App\Helpers\Helper::tm($recibo->saldo_a_favor) }}</td>
            <td class="dinero centrado">{{ \App\Helpers\Helper::tm($recibo->monto_comun) }}</td>
            <td class="dinero centrado">{{ \App\Helpers\Helper::tm($recibo->monto_no_comun) }}</td>
            <td class="dinero centrado">{{ \App\Helpers\Helper::tm($recibo->monto_total_con_deuda) }}</td>
        </tr>
    </table>
    <br>
    <table class="no-table-borders" cellpadding="0" style="width: 100%;">
        <tr>
            <td style="vertical-align:top;width: 50%;">
                <table>
                    <tr>
                        <td colspan="2" class="descripcion border-all centrado">Relación de Gastos/ Ingresos del mes</td>
                    </tr>
                    <tr>
                        <td class="sub-titulo border-all" style="width: 75%;">Descripción</td>
                        <td class="sub-titulo border-all">Monto Bs</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="sub-sub-titulo border-all negritas">Gastos Comunes</td>
                    </tr>
                    @foreach($gastos as $gasto)
                        <tr>
                            <td>{{$gasto->comentarios}}</td>
                            <td class="dinero">{{\App\Helpers\Helper::tm($gasto->monto_egreso)}}</td>
                        </tr>
                    @endforeach
                    <tr class="light-background">
                        <td class="dinero negritas border-top border-bottom">Total Gastos Comunes</td>
                        <td class="dinero negritas border-top border-bottom">{{\App\Helpers\Helper::tm($corte->gastos_comunes)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="sub-sub-titulo border-all negritas">Fondos</td>
                    </tr>
                    @foreach($fondos as $fondo)
                        <tr>
                            <td>{{$fondo->nombre}}</td>
                            <td class="dinero">{{\App\Helpers\Helper::tm($corte->gastos_comunes*$fondo->porcentaje_reserva/100)}}</td>
                        </tr>
                    @endforeach
                    <tr class="light-background">
                        <td class="dinero negritas border-top border-bottom">Total Fondos</td>
                        <td class="dinero negritas border-top border-bottom">{{\App\Helpers\Helper::tm($corte->total_fondos)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="sub-sub-titulo border-all negritas">Gastos no comunes</td>
                    </tr>
                    @foreach($gastosNoComunes as $gasto)
                        <tr>
                            <td>{{$gasto->comentarios}}</td>
                            <td class="dinero">{{\App\Helpers\Helper::tm($gasto->monto_egreso)}}</td>
                        </tr>
                    @endforeach
                    <tr class="light-background">
                        <td class="dinero negritas border-top border-bottom">Total Gastos no Comunes</td>
                        <td class="dinero negritas border-top border-bottom">{{\App\Helpers\Helper::tm($recibo->monto_no_comun)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="sub-sub-titulo border-all negritas">Ingresos</td>
                    </tr>
                    @foreach($ingresos as $ingreso)
                        <tr>
                            <td>{{$ingreso->comentarios}}</td>
                            <td class="dinero">{{\App\Helpers\Helper::tm($ingreso->monto_ingreso)}}</td>
                        </tr>
                    @endforeach
                    <tr class="light-background">
                        <td class="dinero negritas border-top border-bottom">Total Ingresos</td>
                        <td class="dinero negritas border-top border-bottom">{{\App\Helpers\Helper::tm($corte->ingresos)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="recibo-copyright">
                            Recibo emitido or ACONCLOUD. Todos los derechos reservados.<br>
                            Fecha {{ $recibo->created_at->format('d/m/Y') }} Hora: {{ $recibo->created_at->format('H:i') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align:top;width: 50%;">
                <table>
                    <tr>
                        <td colspan="2" class="descripcion border-all centrado">Relación de Pago según alícuota</td>
                    </tr>
                    <tr>
                        <td class="sub-titulo border-all" style="width: 75%;">Descripción</td>
                        <td class="sub-titulo border-all">Monto Bs</td>
                    </tr>
                    <tr>
                        <td>Gastos Comunes</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->monto_comun)}}</td>
                    </tr>
                    <tr>
                        <td>Ingresos</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->ingreso_comun)}}</td>
                    </tr>
                    <tr>
                        <td>% Alícuota</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->vivienda->tipoVivienda->porcentaje_pago)}}</td>
                    </tr>
                    <tr>
                        <td>Cuota parcial</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->monto)}}</td>
                    </tr>
                    <tr>
                        <td>Gastos no Comunes</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->monto_no_comun)}}</td>
                    </tr>
                    <tr>
                        <td>Mora ({{$recibo->porcentaje_mora}}%)</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->monto_mora)}}</td>
                    </tr>
                    <tr>
                        <td class="negritas">Total del mes</td>
                        <td class="dinero negritas">{{\App\Helpers\Helper::tm($recibo->monto_total)}}</td>
                    </tr>
                    <tr>
                        <td>Deuda Acumulada</td>
                        <td class="dinero">{{\App\Helpers\Helper::tm($recibo->deuda_anterior)}}</td>
                    </tr>
                    <tr class="light-background">
                        <td class="dinero negritas border-top border-bottom">Total a Pagar</td>
                        <td class="dinero negritas border-top border-bottom">{{\App\Helpers\Helper::tm($recibo->monto_total_con_deuda)}}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td colspan="2" class="descripcion border-all centrado">Reservas y estado de cuenta del
                            edificio
                        </td>
                    </tr>
                    <tr>
                        <td class="sub-titulo border-all" style="width: 75%;">Reservas</td>
                        <td class="sub-titulo border-all">Monto Bs</td>
                    </tr>
                    @foreach($corte->cuentas as $cuenta)
                        <tr>
                            <td>{{ $cuenta->banco->nombre }}</td>
                            <td class="dinero">{{\App\Helpers\Helper::tm($cuenta->pivot->saldo)}}</td>
                        </tr>
                    @endforeach
                    @foreach($corte->fondos as $fondo)
                        <tr>
                            <td>{{$fondo->nombre}}</td>
                            <td class="dinero">{{\App\Helpers\Helper::tm($fondo->pivot->saldo)}}</td>
                        </tr>
                    @endforeach
                    <tr class="light-background">
                        <td class="dinero negritas border-top border-bottom">Total Fondos</td>
                        <td class="dinero negritas border-top border-bottom">{{\App\Helpers\Helper::tm($corte->fondos->sum('pivor->saldo'))}}</td>
                    </tr>
                    <tr>
                        <td class="sub-titulo" colspan="2" style="text-align: left;">
                            Recuerde que:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {!! p('nota_en_recibo') !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>