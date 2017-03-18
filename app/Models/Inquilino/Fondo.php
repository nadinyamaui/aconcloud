<?php namespace App\Models\Inquilino;

use App\Models\BaseModel;

/**
 * App\Models\Inquilino\Fondo
 *
 * @property integer $id
 * @property integer $cuenta_id
 * @property string $nombre
 * @property float $saldo_actual
 * @property boolean $ind_caja_chica
 * @property float $porcentaje_reserva
 * @property float $monto_maximo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Inquilino\Cuenta $cuenta
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereCuentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereSaldoActual($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereIndCajaChica($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo wherePorcentajeReserva($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereMontoMaximo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\MovimientosCuenta[] $movimientos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\CorteRecibo')->withTimestamps()->withPivot('saldo[]
 *     $corteRecibos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Fondo fondosDisponibles()
 */
class Fondo extends BaseModel
{

    public static $decimalFields = ['saldo_actual', 'porcentaje_reserva', 'monto_maximo', 'monto_reponer'];
    protected $connection = "inquilino";
    protected $table = "fondos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'cuenta_id',
        'nombre',
        'saldo_actual',
        'ind_caja_chica',
        'porcentaje_reserva',
        'monto_maximo',
        'ind_activo'
    ];

    public static function buscarCajaChica()
    {
        return self::whereIndCajaChica(true)->first();
    }

    public static function getWhereCondition()
    {
        return self::whereIndCajaChica(false)->whereIndActivo(true);
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function corteRecibos()
    {
        return $this->belongsToMany(CorteRecibo::class)->withTimestamps()->withPivot('saldo');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientosCuenta::class);
    }

    public function reponer($referencia, $cuenta, $montoReponer)
    {
        if (($this->saldo_actual + $montoReponer) > $this->monto_maximo) {
            $this->addError("monto_reponer", "Este monto de reposición excede el monto base de la caja chica");

            return $this;
        }
        $cuenta = Cuenta::findOrFail($cuenta);
        $clasificacion = ClasificacionIngresoEgreso::reposicionCajaChica();
        $movimiento = $cuenta->retirar($montoReponer, $referencia, "Reposición de caja chica", $clasificacion);
        if ($movimiento->hasErrors()) {
            return $movimiento;
        }
        $this->movimientos()->whereEstatus("PEN")->update(['estatus' => 'PRO']);
        $this->saldo_actual = $this->saldo_actual + $montoReponer;
        $this->save();

        return true;
    }

    public function calcularMontoReposicion($monto)
    {
        return $monto * $this->porcentaje_reserva / 100;
    }

    public function scopeFondosDisponibles($query)
    {
        return $query->whereIndCajaChica(false)->whereIndActivo(true);
    }

    public function scopeFondosActivos($query)
    {
        return $query->whereIndActivo(true);
    }

    public function getPrettyName()
    {
        return "Fondo";
    }

    public function validate()
    {
        if (parent::validate()) {
            $cuenta = $this->cuenta;
            if (!$this->exists && $cuenta->saldo_actual < $this->saldo_actual) {
                $this->addError('saldo_actual', 'No hay suficiente dinero en la cuenta seleccionada');
            }
            if ($this->ind_caja_chica && $this->monto_maximo < $this->saldo_actual) {
                $this->addError(
                    ['monto_maximo', 'saldo_actual'],
                    'El monto base de la caja no puede ser menor al saldo actual.'
                );
            }
            if ($this->ind_caja_chica) {
                $count = self::whereIndCajaChica(true)->where('id', '<>', $this->id == null ? 0 : $this->id)->count();
                if ($count) {
                    $this->addError('ind_caja_chica', 'Solo puede existir una caja chica');
                }
            }
        }

        return !$this->hasErrors();
    }

    protected function getPrettyFields()
    {
        return [
            'cuenta_id'          => 'Cuenta bancaria',
            'nombre'             => 'Nombre del Fondo',
            'saldo_actual'       => 'Saldo Actual',
            'ind_caja_chica'     => '¿Caja chica?',
            'porcentaje_reserva' => '% de reserva o % de reposición',
            'monto_maximo'       => 'Monto base de la caja chica',
            'monto_reponer'      => 'Monto a reponer',
            'ind_activo'         => '¿Activo?'
        ];
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
            'cuenta_id'          => 'required|integer',
            'nombre'             => 'required|max:100',
            'saldo_actual'       => 'required',
            'ind_caja_chica'     => '',
            'porcentaje_reserva' => 'required',
            'monto_maximo'       => 'required_if:ind_caja_chica,1',
        ];
    }
}
