<?php
/**
 * Created by <?phpStorm.
 * User: developer
 * Date: 25-03-2015
 * Time: 07:44 AM
 */

namespace App\Helpers;

use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\MovimientosCuenta;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Conciliacion
{

    public $cuenta;
    public $archivo;
    public $registros;

    public $collectionPendientes;
    public $collectionConciliar;
    public $saldoFinal;
    public $totalIngresos;
    public $totalEgresos;

    public function __construct($archivo, $cuenta_id, $movimientosPendientes = [], $movimientosConciliar = [])
    {
        $this->archivo = $archivo;
        $this->collectionPendientes = new Collection($movimientosPendientes);
        $this->collectionConciliar = new Collection($movimientosConciliar);
        $this->cuenta = Cuenta::findOrFail($cuenta_id);
        $this->saldoFinal = $this->cuenta->saldo_actual;
        $this->totalEgresos = 0;
        $this->totalIngresos = 0;
    }

    public function preparar()
    {
        $lines = file($this->archivo);
        $records = [];
        $record = [];
        $end = 0;
        foreach ($lines as $line) {
            /*
            For each line in the QIF file we will loop through it
            */

            $line = trim($line);

            if ($line === "^") {
                /*
                We have found a ^ which indicates the end of a transaction
                we now set $end as true to add this record array to the master records array
                */

                $end = 1;
            } elseif (preg_match("#^!Type:(.*)$#", $line, $match)) {
                /*
                This will be matched for the first line.
                You can get the type by using - $type = trim($match[1]);
                We dont want to do anything with the first line so we will just ignore it
                */
            } else {
                switch (substr($line, 0, 1)) {
                    case 'D':
                        /*
                        Date. Leading zeroes on month and day can be skipped. Year can be either 4 digits or 2 digits or '6 (=2006).
                        */
                        $record['date'] = trim(substr($line, 1));
                        break;
                    case 'T':
                        /*
                        Amount of the item. For payments, a leading minus sign is required.
                        */
                        $record['amount'] = trim(substr($line, 1));
                        break;
                    case 'P':
                    case 'M':
                        /*
                        Payee. Or a description for deposits, transfers, etc.

                        Note: Yorkshite Bank has some funny space in between words in the description
                        so we will get rid of these
                        */
                        $line = htmlentities($line);
                        $line = str_replace("  ", "", $line);
                        //$line = str_replace(array("&pound;","£"), 'GBP', $line);

                        $record['payee'] = trim(substr($line, 1));
                        break;
                    case 'N':
                        /*
                        Investment Action (Buy, Sell, etc.).
                        */
                        $record['investment'] = trim(substr($line, 1));
                        break;
                }
            }

            if ($end == 1) {
                if ($this->parseMoney($record['amount']) != 0) {
                    // We have reached the end of a transaction so add the record to the master records array
                    $records[] = $record;
                }
                // Rest the $record array
                $record = [];

                // Set $end to false so that we can now build the new record for the next transaction
                $end = 0;
            }
        }
        $this->registros = $records;
        $this->cargarCollection();
    }

    private function parseMoney($monto)
    {
        $monto = str_replace('.', '', $monto);
        $monto = str_replace(',', '.', $monto);

        return (float)$monto;
    }

    public function cargarCollection()
    {
        foreach ($this->registros as $registro) {
            $movimiento = new MovimientosCuenta();
            $movimiento->cuenta_id = $this->cuenta->id;
            $movimiento->referencia = $registro['investment'];
            if ($registro['amount'] < 0) {
                $movimiento->tipo_movimiento = 'ND';
                $movimiento->monto_egreso = abs($this->parseMoney($registro['amount']));
                $this->totalEgresos += abs($this->parseMoney($registro['amount']));
            } else {
                $movimiento->tipo_movimiento = 'NC';
                $movimiento->monto_ingreso = abs($this->parseMoney($registro['amount']));
                $this->totalIngresos += abs($this->parseMoney($registro['amount']));
            }
            $movimiento->fecha_pago = Carbon::createFromFormat('d/m/Y', $registro['date']);
            $movimiento->estatus = 'PEN';
            $movimiento->descripcion = $registro['payee'];

            $movimientos = $this->cuenta->buscarMovimiento(
                $registro['investment'],
                $movimiento->tipo_movimiento,
                false
            );
            foreach ($movimientos as $movimientoDb) {
                if ($movimientoDb->estatus == "PEN") {
                    $this->collectionConciliar->push($movimiento);
                }
            }
            if ($movimientos->count() == 0) {
                $this->saldoFinal += $this->parseMoney($registro['amount']);
                $this->collectionPendientes->push($movimiento);
            }
        }
    }

    public function confirmarConciliacion()
    {
        $saldo = $this->cuenta->saldo_actual;
        $saldo += $this->conciliarCollection($this->collectionConciliar);
        $saldo += $this->conciliarCollection($this->collectionPendientes);
        $this->cuenta->saldo_actual = $saldo;
        $this->cuenta->save();
    }

    private function conciliarCollection($collection)
    {
        $saldo = 0;
        foreach ($collection as $movimiento) {
            $movimientos = $this->cuenta->buscarMovimiento(
                $movimiento['referencia'],
                $movimiento['tipo_movimiento'],
                false
            );
            $movimientos->each(function ($movimientoDb) use ($movimiento) {
                $movimientoDb->fecha_pago = $movimiento['fecha_pago'];
                $movimientoDb->descripcion = $movimiento['descripcion'];
                $movimientoDb->forma_pago = "banco";
                if (!$movimientoDb->ind_movimiento_en_cuotas) {
                    if (isset($movimiento['monto_egreso'])) {
                        $movimientoDb->monto_egreso = $movimiento['monto_egreso'];
                    } else {
                        if (isset($movimiento['monto_ingreso'])) {
                            $movimientoDb->monto_ingreso = $movimiento['monto_ingreso'];
                        }
                    }
                }
                if ($movimientoDb->fecha_factura != null) {
                    $movimientoDb->conciliado();
                }
                if (!$movimientoDb->save()) {
                    dd($movimientoDb, $movimientoDb->getErrors());
                }
            });

            if ($movimientos->count() == 0) {
                $movimientoDb = new MovimientosCuenta();
                $movimientoDb->forma_pago = "banco";
                $movimientoDb->fecha_pago = $movimiento['fecha_pago'];
                $movimientoDb->descripcion = $movimiento['descripcion'];
                if (isset($movimiento['monto_egreso'])) {
                    $movimientoDb->monto_egreso = $movimiento['monto_egreso'];
                    $saldo -= $movimiento['monto_egreso'];
                } else {
                    if (isset($movimiento['monto_ingreso'])) {
                        $movimientoDb->monto_ingreso = $movimiento['monto_ingreso'];
                        $saldo += $movimiento['monto_ingreso'];
                    }
                }
                $movimientoDb->cuenta_id = $movimiento["cuenta_id"];
                $movimientoDb->estatus = "PEN";
                $movimientoDb->referencia = $movimiento['referencia'];
                $movimientoDb->tipo_movimiento = $movimiento['tipo_movimiento'];
                $movimientoDb->save();
            }
        }

        return $saldo;
    }
}
