<?php namespace App\Models\Inquilino;

use App\Helpers\Helper;
use App\Models\App\Inquilino;
use App\Models\BaseModel;
use App\Modules\Comentarios\Comentario;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Inquilino\CorteRecibo
 *
 * @property integer $id
 * @property string $nombre
 * @property string $mes
 * @property integer $ano
 * @property float $ingresos
 * @property float $gastos_comunes
 * @property float $gastos_no_comunes
 * @property float $total_fondos
 * @property string $estatus
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $monto_sin_fondos
 * @property-read mixed $monto_total
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereMes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereAno($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereIngresos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereGastosComunes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereGastosNoComunes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereTotalFondos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereEstatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Recibo[] $recibos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Recibo')->whereEstatus("PAG[]
 *     $recibosPagados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Recibo')->whereEstatus("VEN[]
 *     $recibosVencidos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Recibo')->whereEstatus("GEN[]
 *     $recibosGenerados
 * @property-read mixed $total_recibos
 * @property-read mixed $total_recibos_pagados
 * @property-read mixed $total_recibos_no_pagados
 * @property-read mixed $monto_total_recibos
 * @property-read mixed $monto_total_recibos_pagados
 * @property-read mixed $monto_total_recibos_no_pagados
 * @property \Carbon\Carbon $fecha_vencimiento
 * @property-read mixed $nombre_corto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Recibo')->whereIn("estatus[]
 *     $recibosNoPagados
 * @property-read mixed $porcentaje_recaudacion
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\CorteRecibo whereFechaVencimiento($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Fondo $fondos
 * @property-read mixed $total_fondos_historico
 * @property-read \Illuminate\Database\Eloquent\Collection|Comentario[] $comentarios
 */
class CorteRecibo extends BaseModel
{
    public static $decimalFields = [
        'ingresos',
        'gastos_comunes',
        'gastos_no_comunes',
        'total_fondos',
        'total_cuentas',
        'monto_total',
        'monto_total_recibos',
        'monto_total_recibos_pagados',
        'monto_total_recibos_no_pagados',
        'porcentaje_recaudacion',
    ];
    protected $connection = "inquilino";
    protected $table = "corte_recibos";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'mes',
        'ano',
        'ingresos',
        'gastos_comunes',
        'gastos_no_comunes',
        'total_fondos',
        'total_cuentas',
        'estatus'
    ];

    protected $dates = [
        'fecha_vencimiento'
    ];

    public static function hayPendiente()
    {
        $fechaUltimo = static::fechaUltimoRecibo();
        $hoy = Carbon::now();

        return true;
    }

    public static function fechaUltimoRecibo()
    {
        $diaCorte = Preferencia::buscar('dia_corte_recibo');
        $ultimo = self::orderBy('ano', 'desc')->orderBy('mes', 'desc')->first();
        if (is_null($ultimo)) {
            $anoInicio = Preferencia::buscar('ano_inicio');
            $mesInicio = Preferencia::buscar('mes_inicio');

            return Carbon::createFromDate($anoInicio, $mesInicio, $diaCorte)->subMonth();
        }

        return Carbon::createFromDate($ultimo->ano, $ultimo->mes, $diaCorte);
    }

    public static function generarCorte($mes, $ano)
    {
        $hoy = Carbon::now();
        if ($mes == null) {
            $mes = $hoy->format('n');
        }
        if ($ano == null) {
            $ano = $hoy->format('Y');
        }
        $corte = new CorteRecibo();
        $corte->mes = $mes;
        $corte->ano = $ano;
        $corte->nombre = "Corte de recibos del mes de " . Helper::monthToS($mes) . ' del año ' . $ano;
        $corte->ingresos = $corte->movimientosIngresos()->sum('monto_ingreso');
        $corte->gastos_comunes = $corte->movimientosGastos()->whereIndGastoNoComun(false)->sum('monto_egreso');
        $corte->gastos_no_comunes = $corte->movimientosGastos()->whereIndGastoNoComun(true)->sum('monto_egreso');
        $fondos = Fondo::fondosActivos()->get();
        $corte->total_fondos = 0;
        foreach ($fondos as $fondo) {
            $corte->total_fondos += $fondo->calcularMontoReposicion($corte->gastos_comunes);
        }
        $corte->total_cuentas = Cuenta::activas()->get()->sum('saldo_con_fondos');
        $corte->estatus = "ELA";
        $corte->fecha_vencimiento = Carbon::createFromDate($ano, $mes,
            Preferencia::buscar('dia_corte_recibo'))->addMonth()->lastOfMonth();

        if (is_null($corte->ingresos)){
            $corte->ingresos = 0;
        }
        if (is_null($corte->gastos_no_comunes)){
            $corte->gastos_no_comunes = 0;
        }
        return $corte;
    }

    public function movimientosIngresos()
    {
        return $this->queryBaseMovimientos()->ingreso();
    }

    private function queryBaseMovimientos()
    {
        $query = MovimientosCuenta::afectanCalculos()->where(function ($q) {
            $q->where(function ($q) {
                $q->whereNull('fecha_factura')->whereMonthYear('fecha_pago', $this->mes, $this->ano);
            })->orWhere(function ($q) {
                $q->whereNull('fecha_pago')->whereMonthYear('fecha_factura', $this->mes, $this->ano);
            })->orWhere(function ($q) {
                $q->whereMonthYear('fecha_pago', $this->mes, $this->ano)->whereIndMovimientoEnCuotas(false);
            })->orWhere(function ($q) {
                $q->whereMonthYear('fecha_factura', $this->mes, $this->ano)->whereIndMovimientoEnCuotas(true);
            });
        });

        return $query;
    }

    public function movimientosGastos()
    {
        return $this->queryBaseMovimientos()->gasto();
    }

    public function getPrettyName()
    {
        return "Corte Recibo";
    }

    public function validate()
    {
        if (parent::validate()) {
            $hoy = Carbon::now();
            if ($this->mes > $hoy->month && $this->ano == $hoy->year) {
                $this->addError('mes', 'No puedes generar cortes de recibo a futuro');
            }
        }

        return !$this->hasErrors();
    }

    public function getNombreCortoAttribute()
    {
        return trans('meses.' . $this->mes) . ' ' . $this->ano;
    }

    public function getMontoSinFondosAttribute()
    {
        return $this->gastos_comunes - $this->ingresos;
    }

    public function getMontoTotalAttribute()
    {
        return ($this->gastos_comunes + $this->total_fondos) - $this->ingresos;
    }

    public function movimientosConciliados()
    {
        $movimientosNoConciliados = MovimientosCuenta::whereMonthYear('fecha_factura', $this->mes,
            $this->ano)->whereEstatus('PEN')->count();
        if ($movimientosNoConciliados > 0) {
            return false;
        }

        return true;
    }

    public function generarRecibos($guardar = true)
    {
        if ($guardar) {
            $fondos = Fondo::fondosActivos()->get();
            foreach ($fondos as $fondo) {
                //Se guarda el saldo viejo
                $this->fondos()->attach($fondo->id, ['saldo' => $fondo->saldo_actual]);
            }

            $cuentas = Cuenta::activas()->get();
            foreach ($cuentas as $cuenta) {
                //Se guarda el saldo viejo
                $this->cuentas()->attach($cuenta->id, ['saldo' => $cuenta->saldo_con_fondos]);
            }

            $this->estatus = "ACT";
            $this->save();
        }
        $recibos = new Collection();
        $viviendas = Vivienda::all();
        $viviendas->each(function ($vivienda) use ($guardar, $recibos) {
            $recibos->push($this->generarRecibo($vivienda, $guardar));
        });

        return $recibos;
    }

    public function fondos()
    {
        return $this->belongsToMany(Fondo::class)->withTimestamps()->withPivot('saldo');
    }

    public function cuentas()
    {
        return $this->belongsToMany(Cuenta::class)->withTimestamps()->withPivot('saldo');
    }

    public function generarRecibo(Vivienda $vivienda, $guardar)
    {
        $recibo = new Recibo();
        $recibo->num_recibo = Inquilino::$current->id . $vivienda->id . $this->mes . $this->ano;
        $recibo->corte_recibo_id = $this->id;
        $recibo->vivienda_id = $vivienda->id;
        $recibo->estatus = "GEN";
        $recibo->deuda_anterior = $vivienda->saldo_actual;
        $recibo->monto_no_comun = $vivienda->calcularMontoNoComun($this);
        $recibo->aplicarMorosidad();
        if ($guardar) {
            $recibo->save();
        }

        return $recibo;
    }

    public function puedeGenerarRecibos()
    {
        return $this->estatus == "ELA" && $this->exists;
    }

    public function puedeVerRecibos()
    {
        return $this->estatus == "ACT" && $this->exists;
    }

    public function recibosGenerados()
    {
        return $this->hasMany(Recibo::class)->whereEstatus("GEN");
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'item')->orderBy("created_at", "desc");
    }

    public function getTotalRecibosAttribute()
    {
        return $this->recibos->count();
    }

    public function recibos()
    {
        return $this->hasMany(Recibo::class);
    }

    public function recibosPagados()
    {
        return $this->hasMany(Recibo::class)->whereEstatus("PAG");
    }

    public function recibosNoPagados()
    {
        return $this->hasMany(Recibo::class)->whereIn("estatus", ['VEN', 'GEN', 'PEN']);
    }

    public function getTotalRecibosPagadosAttribute()
    {
        return $this->recibosPagados->count();
    }

    public function getTotalRecibosNoPagadosAttribute()
    {
        return $this->recibosNoPagados->count();
    }

    public function getMontoTotalRecibosAttribute()
    {
        return $this->recibos->sum('monto_total');
    }

    public function getMontoTotalRecibosPagadosAttribute()
    {
        return $this->recibosPagados->sum('monto_total');
    }

    public function getMontoTotalRecibosNoPagadosAttribute()
    {
        return $this->recibosNoPagados->sum('monto_total');
    }

    public function getPorcentajeRecaudacionAttribute()
    {
        if ($this->monto_total_recibos > 0) {
            return $this->monto_total_recibos_pagados * 100 / $this->monto_total_recibos;
        }

        return 0;
    }

    public function getTotalFondosHistoricoAttribute()
    {
        $fondos = $this->fondos;
        $sum = 0;
        foreach ($fondos as $fondo) {
            $sum += $fondo->pivot->saldo;
        }

        return $sum;
    }

    public function anterior()
    {
        $fecha = $this->getFechaCorte();
        $fecha->subMonth();

        return self::where('mes', $fecha->month)->where('ano', $fecha->year)->first();
    }

    public function getFechaCorte()
    {
        return Carbon::createFromDate($this->ano, $this->mes, Preferencia::buscar('dia_corte_recibo'));
    }

    public function proximo()
    {
        $fecha = $this->getFechaCorte();
        $fecha->addMonth();

        return self::where('mes', $fecha->month)->where('ano', $fecha->year)->first();
    }

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save,
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran
     * persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     * @return array
     */
    protected function getRules()
    {
        return [
            'nombre' => 'required',
            'mes' => 'required|integer',
            'ano' => 'required|integer',
            'fecha_vencimiento' => 'required',
            'ingresos' => 'required',
            'gastos_comunes' => 'required',
            'gastos_no_comunes' => 'required',
            'total_fondos' => 'required',
            'estatus' => 'required',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Nombre',
            'mes' => 'Mes',
            'ano' => 'Año',
            'fecha_vencimiento' => 'Vencimiento',
            'ingresos' => 'Ingresos',
            'gastos_comunes' => 'Gastos Comunes',
            'gastos_no_comunes' => 'Gastos no comunes',
            'total_fondos' => 'Fondos',
            'monto_total' => 'Monto del corte',
            'estatus' => 'Estatus',
            'estatus_display' => 'Estatus',
        ];
    }
}
