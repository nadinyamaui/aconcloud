<?php namespace App\Models\Inquilino;

use App\Jobs\ReciboVencido;
use App\Models\BaseModel;
use App\Modules\Comentarios\Comentario;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * App\Models\Inquilino\Recibo
 *
 * @property-read mixed $estatus_display
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property integer $id
 * @property integer $corte_recibo_id
 * @property integer $vivienda_id
 * @property float $monto_no_comun
 * @property float $deuda_anterior
 * @property float $porcentaje_mora
 * @property float $monto_mora
 * @property string $estatus
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereCorteReciboId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereViviendaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereMontoNoComun($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereDeudaAnterior($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo wherePorcentajeMora($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereMontoMora($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereEstatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereUpdatedAt($value)
 * @property-read mixed $monto_comun
 * @property-read \App\Models\Inquilino\Vivienda $vivienda
 * @property-read \App\Models\Inquilino\CorteRecibo $corteRecibo
 * @property-read mixed $monto_total
 * @property string $num_recibo
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Recibo whereNumRecibo($value)
 * @method static \App\Models\Inquilino\Recibo aplicarFiltro($filtros)
 * @property-read mixed $ingreso_comun
 * @property-read mixed $monto_sin_mora_total
 * @property-read mixed $monto_total_con_deuda
 * @property-read \Illuminate\Database\Eloquent\Collection|Comentario[] $comentarios
 */
class Recibo extends BaseModel
{

    use DispatchesJobs;
    public static $decimalFields = [
        'monto_no_comun',
        'deuda_anterior',
        'porcentaje_mora',
        'monto_mora',
        'monto_comun',
        'monto_total',
        'monto_total_con_deuda'
    ];
    protected $connection = "inquilino";
    protected $table = "recibos";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'corte_recibo_id',
        'vivienda_id',
        'monto_no_comun',
        'deuda_anterior',
        'porcentaje_mora',
        'monto_mora',
        'estatus',
        'monto_total_con_deuda'
    ];

    public static function verificarRecibosVencidos()
    {
        $hoy = Carbon::now();
        $recibosVencidos = Recibo::
        join('corte_recibos', 'corte_recibos.id', '=', 'recibos.corte_recibo_id')
            ->whereIn("recibos.estatus", ["GEN"])->where('fecha_vencimiento', '<=',
                $hoy)->select('recibos.*')->distinct()->get();

        foreach ($recibosVencidos as $recibo) {
            $recibo->vencido();
        }
    }

    public function getPrettyName()
    {
        return "Recibo";
    }

    public function getMontoComunAttribute()
    {
        $tipo = $this->vivienda->tipoVivienda;

        return $tipo->porcentaje_pago * $this->corteRecibo->monto_total / 100;
    }

    public function getMontoComunSinFondosAttribute()
    {
        $tipo = $this->vivienda->tipoVivienda;

        return $tipo->porcentaje_pago * $this->corteRecibo->monto_sin_fondos / 100;
    }

    public function getMontoComunDeFondosAttribute()
    {
        $tipo = $this->vivienda->tipoVivienda;

        return $tipo->porcentaje_pago * $this->corteRecibo->total_fondos / 100;
    }

    public function getIngresoComunAttribute()
    {
        $tipo = $this->vivienda->tipoVivienda;

        return $tipo->porcentaje_pago * $this->corteRecibo->ingresos / 100;
    }

    public function getMontoTotalAttribute()
    {
        return round($this->monto_comun + $this->monto_mora + $this->monto_no_comun, 2);
    }

    public function getMontoSinMoraTotalAttribute()
    {
        return $this->monto_comun + $this->monto_no_comun;
    }

    public function getMontoTotalConDeudaAttribute()
    {
        $value = $this->monto_total + $this->deuda_anterior;

        return $value < 0 ? 0 : $value;
    }

    public function getSaldoDeudorAttribute()
    {
        return $this->deuda_anterior < 0 ? 0 : $this->deuda_anterior;
    }

    public function getSaldoAFavorAttribute()
    {
        return $this->deuda_anterior < 0 ? $this->deuda_anterior : 0;
    }

    public function vivienda()
    {
        return $this->belongsTo(Vivienda::class);
    }

    public function corteRecibo()
    {
        return $this->belongsTo(CorteRecibo::class);
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'item')->orderBy("created_at", "desc");
    }

    public function scopeAplicarFiltro($query, array $filtros)
    {
        $query->select('recibos.*');
        $query->join('viviendas', 'viviendas.id', '=', 'recibos.vivienda_id');
        $query->join('tipo_viviendas', 'tipo_viviendas.id', '=', 'viviendas.tipo_vivienda_id');
        if (isset($filtros['corte_id'])) {
            $query->whereCorteReciboId($filtros['corte_id']);
        }
        if (isset($filtros['tipo_vivienda_id'])) {
            $query->where('viviendas.tipo_vivienda_id', $filtros['tipo_vivienda_id']);
        }
        if (isset($filtros['vivienda_id'])) {
            $query->where('recibos.vivienda_id', $filtros['vivienda_id']);
        }
        if (isset($filtros['estatus'])) {
            if (is_array($filtros['estatus'])) {
                $query->whereIn('estatus', $filtros['estatus']);
            } else {
                $query->where('estatus', $filtros['estatus']);
            }
        }
    }

    public function aplicarMorosidad()
    {
        if ($this->leAplicaMorosidad()) {
            $interes = Preferencia::buscar('porcentaje_morosidad');
            $this->porcentaje_mora = $interes;
            $this->monto_mora = $this->monto_total * $interes / 100;
        } else {
            $this->porcentaje_mora = 0;
            $this->monto_mora = 0;
        }
    }

    public function leAplicaMorosidad()
    {
        $cantidadVencidos = Recibo::whereViviendaId($this->vivienda_id)->whereEstatus("VEN")->count();
        $inicioMora = (int)Preferencia::buscar('inicio_morosidad');

        return $cantidadVencidos >= $inicioMora;
    }

    public function vencido()
    {
        $this->update(['estatus' => 'VEN']);
        $this->dispatch(new ReciboVencido($this->id));
    }

    public function pendiente()
    {
        $this->estatus = "PEN";
        $this->save();
    }

    public function pagadoAutomatico()
    {
        $pago = Pago::whereViviendaId($this->vivienda_id)->whereEstatus("PRO")->orderBy('id', 'desc')->first();
        if (is_object($pago)) {
            $pago->recibos()->save($this);
            $pago->monto_marcado = $pago->recibos->sum('monto_total');
            $pago->save();
        }
        $this->pagado(true);
    }

    public function pagado($pago_automatico = false)
    {
        $this->agregarDineroAlFondo();
        $this->estatus = "PAG";
        if (!$pago_automatico){
            $this->vivienda->saldo_actual -= $this->monto_total;
        }
        $this->push();
    }

    private function agregarDineroAlFondo()
    {
        $corte = $this->corteRecibo;
        $tipoVivienda = $this->vivienda->tipoVivienda;
        $fondos = $corte->fondos;

        foreach ($fondos as $fondo) {
            $montoReposicionFondo = $fondo->calcularMontoReposicion($corte->gastos_comunes);
            $montoReponer = $montoReposicionFondo * $tipoVivienda->porcentaje_pago / 100;
            $fondo->saldo_actual += $montoReponer;
            $fondo->cuenta->saldo_actual -= $montoReponer;
            $fondo->push();
        }
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
            'num_recibo' => 'required',
            'corte_recibo_id' => 'required',
            'vivienda_id' => 'required|integer',
            'monto_no_comun' => 'required',
            'deuda_anterior' => 'required',
            'porcentaje_mora' => '',
            'monto_mora' => '',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'num_recibo' => 'Número',
            'corte_recibo_id' => 'Corte de recibo',
            'vivienda_id' => 'Vivienda',
            'monto_no_comun' => 'Gastos no comunes',
            'monto_comun' => 'Gastos comunes',
            'deuda_anterior' => 'Deuda anterior',
            'porcentaje_mora' => '% de mora',
            'monto_mora' => 'Monto por mora',
            'monto_total' => 'Monto total del recibo',
            'monto_total_con_deuda' => 'Monto total a pagar',
            'estatus_display' => 'Estatus',
        ];
    }
}
