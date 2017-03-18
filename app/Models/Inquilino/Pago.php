<?php namespace App\Models\Inquilino;

use App\Helpers\Helper;
use App\Models\BaseModel;
use App\Modules\Comentarios\Comentario;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Inquilino\Pago
 *
 * @property integer $id
 * @property integer $vivienda_id
 * @property integer $movimiento_cuenta_id
 * @property float $monto_pagado
 * @property float $total_relacion
 * @property string $comentarios
 * @property string $estatus
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\App\MovimientosCuenta $movimientoCuenta
 * @property-read \App\Models\Inquilino\Vivienda $vivienda
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Recibo[] $recibos
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereViviendaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereMovimientoCuentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereMontoPagado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereTotalRelacion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereComentarios($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereEstatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Pago whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @method static \App\Models\Inquilino\Pago aplicarFiltro($filtros)
 */
class Pago extends BaseModel
{

    public static $decimalFields = ['monto_pagado', 'monto_recibos', 'total_relacion'];
    protected $connection = "inquilino";
    protected $table = "pagos";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'vivienda_id',
        'movimiento_cuenta_id',
        'monto_pagado',
        'total_relacion',
        'estatus'
    ];

    public static function agregarPago(array $values)
    {
        $pago = new Pago($values);
        $recibos = $pago->buscarRecibos();
        $pago->total_relacion = $recibos->sum('monto_total');

        $movimiento = $pago->generarMovimiento($values, $recibos);
        if ($movimiento->hasErrors()) {
            return $movimiento;
        }
        if ($pago->save()) {
            $pago->recibos()->sync($recibos->pluck('id')->all());
            $pago->tratarDeProcesar();
        }

        return $pago;
    }

    public function buscarRecibos()
    {
        $ret = new Collection();
        $recibos = Recibo::whereViviendaId($this->vivienda_id)->whereIn(
            'estatus',
            ['GEN', 'VEN']
        )->orderBy('id')->get();

        $montoDisponible = Helper::tf($this->monto_pagado) + $this->vivienda->saldo_a_favor;
        foreach ($recibos as $recibo) {
            if (($montoDisponible - $recibo->monto_total) >= 0) {
                $ret->push($recibo);
                $montoDisponible -= $recibo->monto_total;
            }
        }

        return $ret;
    }

    /**
     * @param array $values
     * @param $pago
     * @param $recibos
     *
     * @return MovimientosCuenta
     */
    public function generarMovimiento(array $values, $recibos)
    {
        $movimiento = new MovimientosCuenta();
        $movimiento->clasificacion()->associate(ClasificacionIngresoEgreso::pagoRecibos());
        $movimiento->cuenta_id = $values['cuenta_id'];
        $movimiento->monto_ingreso = $this->monto_pagado;
        $movimiento->referencia = $values['referencia'];
        $movimiento->tipo_movimiento = "NC";
        $movimiento->comentarios = "Pago de recibos " . (implode(
            ', ',
            $recibos->pluck('num_recibo')->all()
        ) . ' de la vivienda ') . $this->vivienda->nombre;
        $movimiento->fecha_factura = Carbon::now();
        $movimiento->numero_factura = "N/A";
        $movimiento->forma_pago = "banco";
        $movimiento->actualizarCrear();
        $movimiento->ind_afecta_calculos = false;
        $movimiento->save();
        $this->movimiento_cuenta_id = $movimiento->id;

        return $movimiento;
    }

    public function recibos()
    {
        return $this->morphToMany(Recibo::class, 'item', 'relaciones_pago', 'pago_id', 'item_id')
            ->withTimestamps();
    }

    public function tratarDeProcesar()
    {
        $this->sincronizarMontoPagado();
        $this->procesarRecibos();
        $this->actualizarSaldoVivienda();
    }

    public function sincronizarMontoPagado()
    {
        $this->monto_pagado = $this->movimientoCuenta->monto_ingreso;
        $this->save();
    }

    private function procesarRecibos()
    {
        $callback = function (Recibo $recibo) {
            $recibo->pendiente();
        };
        if ($this->movimientoCuenta->estatus == "PRO") {
            $callback = function (Recibo $recibo) {
                $recibo->pagado();
            };
            $this->estatus = "PRO";
            $this->save();
        }
        $this->recibos->each($callback);
    }

    public function actualizarSaldoVivienda()
    {
        if ($this->estatus == "PRO") {
            $this->vivienda->saldo_actual -= $this->monto_pagado;
            $this->vivienda->save();
        }
    }

    public function getPrettyName()
    {
        return "Cuenta";
    }

    public function movimientoCuenta()
    {
        return $this->belongsTo(MovimientosCuenta::class, 'movimiento_cuenta_id');
    }

    public function vivienda()
    {
        return $this->belongsTo(Vivienda::class, 'vivienda_id');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'item')->orderBy("created_at", "desc");
    }

    public function puedeEliminar()
    {
        return $this->estatus == "PEN";
    }

    public function puedeEditar()
    {
        return $this->estatus == "PEN";
    }

    public function scopeAplicarFiltro($query, array $filtros)
    {
        if (isset($filtros['estatus'])) {
            $query->whereEstatus($filtros['estatus']);
        }

        return $query;
    }

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save,
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran
     * persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected function getRules()
    {
        return [
            'vivienda_id' => 'required|integer',
            'movimiento_cuenta_id' => 'required|integer',
            'monto_pagado' => 'required|numeric|min:' . $this->total_relacion,
            'total_relacion' => 'required',
            'estatus' => '',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'total_relacion' => 'Monto marcado',
            'vivienda_id' => 'Vivienda',
            'movimiento_cuenta_id' => 'Movimiento de la cuenta',
            'monto_pagado' => 'Monto del pago',
            'estatus' => 'Estatus',
            'estatus_display' => 'Estatus',
        ];
    }
}
