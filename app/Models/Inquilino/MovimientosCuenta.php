<?php namespace App\Models\Inquilino;

use App\Models\BaseModel;
use App\Modules\Comentarios\Comentario;
use Carbon\Carbon;

/**
 * App\Models\Inquilino\MovimientosCuenta
 *
 * @property integer $id
 * @property integer $cuenta_id
 * @property integer $fondo_id
 * @property integer $clasificacion_id
 * @property string $referencia
 * @property string $tipo_movimiento
 * @property float $monto_ingreso
 * @property float $monto_egreso
 * @property string $fecha_pago
 * @property string $fecha_factura
 * @property string $descripcion
 * @property string $estatus
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Cuenta $cuenta
 * @property-read \App\Clasificacion $clasificacion
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereCuentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereFondoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta
 *     whereClasificacionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereReferencia($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta
 *     whereTipoMovimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereMontoIngreso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereMontoEgreso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereFechaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereFechaFactura($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereEstatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereUpdatedAt($value)
 * @property string $numero_factura
 * @property string $forma_pago
 * @property string $comentarios
 * @property boolean $ind_gasto_no_comun
 * @property-read \App\Models\Inquilino\Fondo $fondo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Vivienda[] $viviendas
 * @property-read mixed $monto
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereNumeroFactura($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereFormaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereComentarios($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta
 *     whereIndGastoNoComun($value)
 * @method static \App\Models\Inquilino\MovimientosCuenta esteMes()
 * @method static \App\Models\Inquilino\MovimientosCuenta gasto()
 * @method static \App\Models\Inquilino\MovimientosCuenta ingreso()
 * @method static \App\Models\Inquilino\MovimientosCuenta pendiente()
 * @method static \App\Models\Inquilino\MovimientosCuenta procesado()
 * @method static \App\Models\Inquilino\MovimientosCuenta banco()
 * @method static \App\Models\Inquilino\MovimientosCuenta aplicarFiltro($values)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property boolean $ind_afecta_calculos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta
 *     whereIndAfectaCalculos($value)
 * @method static \App\Models\Inquilino\MovimientosCuenta afectanCalculos()
 * @property-read \App\Models\Inquilino\MovimientosCuenta $movimientoPadre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Vivienda[] $movimientoCuotas
 * @property integer $movimiento_cuenta_cuota_id
 * @property boolean $ind_movimiento_en_cuotas
 * @property integer $cuota_numero
 * @property integer $total_cuotas
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta
 *     whereMovimientoCuentaCuotaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta
 *     whereIndMovimientoEnCuotas($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereCuotaNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereTotalCuotas($value)
 * @property float $monto_inicial
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MovimientosCuenta whereMontoInicial($value)
 * @property-read \App\Models\Inquilino\Pago $pago
 * @property-read \Illuminate\Database\Eloquent\Collection|Alarma[] $alarmas
 */
class MovimientosCuenta extends BaseModel
{

    public static $decimalFields = ['monto_ingreso', 'monto_egreso', 'monto_inicial'];
    protected $connection = "inquilino";
    protected $table = "movimientos_cuenta";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'cuenta_id',
        'clasificacion_id',
        'referencia',
        'tipo_movimiento',
        'monto_ingreso',
        'monto_egreso',
        'fecha_pago',
        'fecha_factura',
        'descripcion',
        'estatus',
        'numero_factura',
        'comentarios',
        'fondo_id',
        'forma_pago',
        'movimiento_cuenta_cuota_id',
        'ind_movimiento_en_cuotas',
        'cuota_numero',
        'total_cuotas',
        'porcentaje_cuotas',
        'monto_inicial'
    ];

    protected $dates = ['fecha_factura', 'fecha_pago'];

    public function getPrettyName()
    {
        return "movimientos_cuenta";
    }

    /**
     * Define una relación pertenece a Cuenta
     * @return Cuenta
     */
    public function cuenta()
    {
        return $this->belongsTo('App\Models\Inquilino\Cuenta');
    }

    /**
     * Define una relación pertenece a Clasificacion
     * @return Clasificacion
     */
    public function clasificacion()
    {
        return $this->belongsTo('App\Models\Inquilino\ClasificacionIngresoEgreso');
    }

    /**
     * Define una relación pertenece a Clasificacion
     * @return Clasificacion
     */
    public function fondo()
    {
        return $this->belongsTo('App\Models\Inquilino\Fondo');
    }

    public function movimientoPadre()
    {
        return $this->belongsTo('App\Models\Inquilino\MovimientosCuenta', 'movimiento_cuenta_cuota_id');
    }

    public function pago()
    {
        return $this->hasOne('App\Models\Inquilino\Pago', 'movimiento_cuenta_id');
    }

    public function movimientoCuotas()
    {
        return $this->hasMany('App\Models\Inquilino\MovimientosCuenta', 'movimiento_cuenta_cuota_id');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'item')->orderBy("created_at", "desc");
    }

    public function alarmas()
    {
        return $this->morphMany(Alarma::class, 'item');
    }

    public function scopeGasto($query)
    {
        return $query->whereNull('monto_ingreso')->whereNotNull('clasificacion_id');
    }

    public function scopeIngreso($query)
    {
        $clasificacionRecibo = ClasificacionIngresoEgreso::pagoRecibos();

        return $query->whereNull('monto_egreso')
            ->whereNotNull('clasificacion_id')
            ->where('clasificacion_id', '<>', $clasificacionRecibo->id);
    }

    public function scopePendiente($query)
    {
        return $query->whereEstatus("PEN");
    }

    public function scopeProcesado($query)
    {
        return $query->whereEstatus("PRO");
    }

    public function scopeBanco($query)
    {
        return $query->whereFormaPago("banco");
    }

    public function scopeAplicarFiltro($query, array $values)
    {
        if (isset($values['clasificacion_id'])) {
            $query->whereClasificacionId($values['clasificacion_id']);
        }
        if (isset($values['fondo_id'])) {
            $query->whereFondoId($values['fondo_id']);
        }
        if (isset($values['mes'])) {
            $query->where(function ($q) use ($values) {
                $q->where(function ($q) use ($values) {
                    $q->whereNull('fecha_factura')->whereMonth('fecha_pago', $values['mes']);
                })->orWhere(function ($q) use ($values) {
                    $q->whereNull('fecha_pago')->whereMonth('fecha_factura', $values['mes']);
                })->orWhere(function ($q) use ($values) {
                    $q->whereMonth('fecha_pago', $values['mes'])->whereIndMovimientoEnCuotas(false);
                })->orWhere(function ($q) use ($values) {
                    $q->whereMonth('fecha_factura', $values['mes'])->whereIndMovimientoEnCuotas(true);
                });
            });
        }
        if (isset($values['ano'])) {
            $query->where(function ($q) use ($values) {
                $q->where(function ($q) use ($values) {
                    $q->whereNull('fecha_factura')->whereYear('fecha_pago', $values['ano']);
                })->orWhere(function ($q) use ($values) {
                    $q->whereNull('fecha_pago')->whereYear('fecha_factura', $values['ano']);
                })->orWhere(function ($q) use ($values) {
                    $q->whereYear('fecha_pago', $values['ano'])->whereIndMovimientoEnCuotas(false);
                })->orWhere(function ($q) use ($values) {
                    $q->whereYear('fecha_factura', $values['ano'])->whereIndMovimientoEnCuotas(true);
                });
            });
        }
        if (isset($values['ind_gasto_no_comun'])) {
            $query->whereIndGastoNoComun($values['ind_gasto_no_comun']);
        }
        if (isset($values['estatus'])) {
            $query->whereEstatus($values['estatus']);
        }

        return $query;
    }

    public function getMontoAttribute()
    {
        if ($this->monto_egreso > 0) {
            return $this->monto_egreso;
        }

        return $this->monto_ingreso;
    }

    public function getComentariosAttribute($value)
    {
        if ($this->ind_movimiento_en_cuotas) {
            $value .= " Cuota " . $this->cuota_numero . ' de ' . $this->total_cuotas;
        }

        return $value;
    }

    public function validate()
    {
        if (parent::validate()) {
            if ($this->fecha_factura != null && $this->fecha_factura->gt(Carbon::now()) && $this->ind_movimiento_en_cuotas == false) {
                $this->addError('fecha_factura', 'No puedes registrar facturas con una fecha mayor a el dia de hoy');
            }
            if ($this->exists && $this->isDirty('forma_pago') && $this->getOriginal('forma_pago') != "") {
                $this->addError('forma_pago', 'No puedes cambiar la forma de pago ');
            }
            if ($this->fondo_id != "" && $this->cuenta_id != "") {
                $this->addError("fondo_id",
                    "Debes seleccionar un fondo o una cuenta pero no ambos. El fondo ya tiene una cuenta asociada");
                $this->addError("cuenta_id",
                    "Debes seleccionar un fondo o una cuenta pero no ambos. El fondo ya tiene una cuenta asociada");
            }
            if ($this->forma_pago != "" && $this->isDirty('monto_egreso')) {
                $fondo = $this->fondo;
                $montoAnterior = 0;
                if ($this->exists) {
                    $montoAnterior = $this->getDirty()['monto_egreso'];
                }
                if (is_object($fondo) && ($fondo->saldo_actual + $montoAnterior) < $this->monto_egreso) {
                    $this->addError('monto_egreso', 'No hay suficiente dinero en el fondo seleccionado');
                }
                $cuenta = $this->cuenta;
                if (is_object($cuenta) && ($cuenta->saldo_actual + $montoAnterior) < $this->monto_egreso) {
                    $this->addError('monto_egreso', 'No hay suficiente dinero en la cuenta seleccionada');
                }
            }
            if ($this->forma_pago == "banco") {
                $duplicado = self::whereReferencia($this->referencia)
                        ->whereCuentaId($this->buscarCuentaId())
                        ->whereTipoMovimiento($this->tipo_movimiento)
                        ->whereNotNull('clasificacion_id')
                        ->whereIndMovimientoEnCuotas(false)
                        ->where('id', '<>', $this->id == null ? 0 : $this->id)->count() > 0;
                if ($duplicado) {
                    $this->addError('referencia', 'Ya existe un ingreso/ egreso con esta misma referencia');
                }
                if ($this->exists) {
                    if ($this->isDirty('cuenta_id') && !is_null($this->fondo_id)) {
                        $this->addError(['cuenta_id', 'fondo_id'],
                            'Para poder el cambiar el gasto a un fondo debe eliminarlo y volverlo a registrar');
                    }
                    if ($this->isDirty('fondo_id') && !is_null($this->cuenta_id)) {
                        $this->addError(['cuenta_id', 'fondo_id'],
                            'Para poder el cambiar el gasto a una cuenta debe eliminarlo y volverlo a registrar');
                    }
                }
            }
        }

        return !$this->hasErrors();
    }

    public function buscarCuentaId()
    {
        if ($this->cuenta_id != null) {
            return $this->cuenta_id;
        } else {
            if ($this->fondo_id != null) {
                return $this->fondo->cuenta_id;
            }
        }
    }

    public function puedeEditar()
    {
        $codigo = !is_null($this->clasificacion_id) ? $this->clasificacion->codigo : "";

        return ($this->estatus == "PEN" || !$this->exists) && $codigo == "";
    }

    public function puedeEliminar()
    {
        return $this->estatus == "PEN";
    }

    public function actualizarCrear()
    {
        $this->calcularMontosCuotas();

        if ($this->forma_pago == "banco") {
            $cuenta = $this->cuenta;
            if (!is_object($cuenta)) {
                $cuenta = $this->fondo->cuenta;
            }
            $gastoExistente = $cuenta->buscarMovimiento($this->referencia, $this->tipo_movimiento);
            //se cargo primero el estado de cuenta
            if ($gastoExistente->exists && $gastoExistente->clasificacion_id == null) {
                $data = array_only($this->toArray(), [
                    'clasificacion_id',
                    'fecha_factura',
                    'numero_factura',
                    'comentarios',
                    'ind_movimiento_en_cuotas',
                    'total_cuotas'
                ]);

                $gastoExistente->fill($data);
                $gastoExistente->calcularMontosCuotas();
                $gastoExistente->tratarDeProcesar();
                $gastoExistente->save();
                $gastoExistente->registrarCuotas();
                if ($this->exists && $this->id != $gastoExistente->id) {
                    $this->delete();
                }
                $this->clearErrors();
                $this->exists = true;
                $this->id = $gastoExistente->id;

            } else {
                $this->save();
                $this->registrarCuotas();
            }
        } else {
            $this->save();
            $this->registrarCuotas();
        }
    }

    public function calcularMontosCuotas()
    {
        if ($this->ind_movimiento_en_cuotas) {
            $this->monto_inicial = $this->monto;
            $this->cuota_numero = 1;
            $montoCuotas = $this->monto * ($this->porcentaje_cuotas/100);
            $this->asignarMonto($montoCuotas / $this->total_cuotas);
        }
    }

    public function asignarMonto($monto)
    {
        if ($this->monto_egreso > 0) {
            $this->monto_egreso = $monto;
        } else {
            $this->monto_ingreso = $monto;
        }
    }

    public function tratarDeProcesar()
    {
        if ($this->fecha_pago != null && $this->referencia != "" && $this->descripcion != "") {
            $this->estatus = "PRO";
        }
    }

    private function registrarCuotas()
    {
        $montoMovimientoBase=$this->monto_inicial;

        if ($this->total_cuotas >= 2) {
            for ($i = 2; $i <= $this->total_cuotas; $i++) {
                $newGasto = new MovimientosCuenta($this->toArray());
                //el mutator le pone parte x de total varias veces
                $newGasto->comentarios = $this->attributes['comentarios'];
                $newGasto->cuota_numero = $i;
                $newGasto->fecha_factura = $this->fecha_factura->copy()->addMonths($i - 1);
                $newGasto->movimiento_cuenta_cuota_id = $this->id;
                $newGasto->save();
                if ($newGasto->hasErrors()) {
                    dd($newGasto->getErrors());
                }
            }

            $montoMovimientoBase*=(100-$this->porcentaje_cuotas)/100;
        }

        if ($this->porcentaje_cuotas!=100) {
            $movimientoBase = new MovimientosCuenta($this->toArray());
            $movimientoBase->movimiento_cuenta_cuota_id = $this->id;
            $movimientoBase->fecha_factura=$this->fecha_factura;
            $movimientoBase->asignarMonto($montoMovimientoBase);
        
            $movimientoBase->save();
            if ($movimientoBase->hasErrors()) {
                dd($movimientoBase->getErrors());
            }
        }



    }

    public function asociarViviendas(array $viviendas)
    {
        if ($this->forma_pago == "banco") {
            $this->viviendas()->sync($viviendas);
            $this->movimientoCuotas->each(function ($movimiento) use ($viviendas) {
                $movimiento->viviendas()->sync($viviendas);
            });
        }
    }

    public function viviendas()
    {
        return $this->belongsToMany('App\Models\Inquilino\Vivienda', 'gasto_vivienda', 'gasto_id', 'vivienda_id')
            ->withTimestamps();
    }

    public function conciliar(MovimientosCuenta $estado)
    {
        if ($this->puedeConciliar($estado)) {
            $this->referencia = $estado->referencia;
            $this->descripcion = $estado->descripcion;
            $this->fecha_pago = $estado->fecha_pago;
            $this->conciliado();
            $estado->delete();

            if ($this->cuenta_id != null) {
                if ($this->tipo_movimiento == "ND") {
                    $this->cuenta->saldo_actual += $this->monto_egreso;
                } else {
                    $this->cuenta->saldo_actual += $this->monto_ingreso;
                }
            } else {
                if ($this->fondo_id != null) {
                    if ($this->tipo_movimiento == "ND") {
                        $this->fondo->saldo_actual += $this->monto_egreso;
                    } else {
                        $this->fondo->saldo_actual += $this->monto_ingreso;
                    }
                }
            }
        }
    }

    public function puedeConciliar(MovimientosCuenta $otro)
    {
        if ($otro->tipo_movimiento != $this->tipo_movimiento) {
            $this->addError('tipo_movimiento', 'Los movimientos son de diferentes tipos no se puede conciliar');
        }
        if ($otro->monto != $this->monto) {
            $this->addError('tipo_movimiento', 'Los montos deben ser iguales para poder conciliarlos');
        }
        if ($this->buscarCuentaId() != $otro->buscarCuentaId()) {
            $this->addError('tipo_movimiento',
                'Los movimientos deben ser de la misma cuenta para cuenta poderlos conciliar');
        }

        return !$this->hasErrors();
    }

    public function conciliado()
    {
        $this->estatus = "PRO";
        $this->save();
        if (is_object($this->pago)) {
            $this->pago->tratarDeProcesar();
        }
        $this->procesarAlarmas();
        $this->save();
    }

    private function procesarAlarmas()
    {
        $this->alarmas->each(function ($alarma) {
            $alarma->ind_atendida = true;
            $alarma->save();
        });
    }

    public function scopeAfectanCalculos($query)
    {
        return $query->whereIndAfectaCalculos(true);
    }

    public function eliminar()
    {
        //si estas eliminando algun hijo se borra al padre, el se encargara de eliminar a los hijos
        if (is_object($this->movimientoPadre)) {
            return $this->movimientoPadre->delete();
        }

        return parent::delete();
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
        $reglas = [
            'forma_pago' => 'required',
            'total_cuotas' => 'required_if:ind_movimiento_en_cuotas,1|integer|max:12|min:2',
            'porcentaje_cuotas'=>'required_if:ind_movimiento_en_cuotas,1|integer|max:100|min:1'
        ];
        if ($this->tipo_movimiento == "ND") {
            $reglas['monto_egreso'] = 'required';
        } else {
            $reglas['monto_ingreso'] = 'required';
        }
        if ($this->forma_pago != "" && is_null($this->fecha_pago)) {
            $reglas['clasificacion_id'] = 'required';
            $reglas['fecha_factura'] = 'required';
            $reglas['numero_factura'] = 'required';
        }
        if ($this->forma_pago == "efectivo") {
            $reglas['fondo_id'] = 'required';
        } else {
            if ($this->forma_pago == "banco") {
                $reglas['cuenta_id'] = 'required_without:fondo_id';
                $reglas['fondo_id'] = 'required_without:cuenta_id';
                $reglas['referencia'] = 'required';
            }
        }

        return $reglas;
    }

    protected function getPrettyFields()
    {
        return [
            'cuenta_id' => 'Cuenta Bancaria',
            'clasificacion_id' => 'Clasificaci&oacute;n',
            'fondo_id' => 'Fondo',
            'numero_factura' => 'N&uacute;mero de factura o recibo',
            'referencia' => 'Nro Pago',
            'tipo_movimiento' => 'Tipo de movimiento',
            'monto_ingreso' => 'Ingreso',
            'monto_egreso' => 'Egreso',
            'monto' => 'Monto',
            'forma_pago' => 'Forma Pago',
            'fecha_pago' => 'Fecha de pago',
            'fecha_factura' => 'Fecha de factura',
            'descripcion' => 'Descripción',
            'estatus' => 'Estatus',
            'comentarios' => 'Comentarios',
            'viviendas' => 'Viviendas involucradas',
            'ind_gasto_no_comun' => '¿Gasto no Común?',
            'estatus_display' => 'Estatus',
            'ind_movimiento_en_cuotas' => '¿Separado en cuotas?',
            'cuota_numero' => 'Número de Cuota',
            'total_cuotas' => 'Total de Cuotas',
            'porcentaje_cuotas' => 'Porcentaje en Cuotas',
            'monto_inicial' => 'Monto total del movimiento',
        ];
    }
}
