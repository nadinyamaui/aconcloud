<?php namespace App\Models\Inquilino;

use App\Models\App\Banco;
use App\Models\BaseModel;
use Carbon\Carbon;

/**
 * App\Models\Inquilino\Cuenta
 *
 * @property integer $id
 * @property integer $banco_id
 * @property string $numero
 * @property float $saldo_actual
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\App\Banco $banco
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Cuenta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Cuenta whereBancoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Cuenta whereNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Cuenta whereSaldoActual($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Cuenta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Cuenta whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\MovimientosCuenta')->orderBy('fecha_pago[]
 *     $movimientos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Fondo')->whereIndCajaChica(false[]
 *     $fondos
 * @property-read mixed $nombre
 * @property-read mixed $saldo_con_fondos
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property-read mixed $saldo_fondos
 */
class Cuenta extends BaseModel
{

    public static $decimalFields = ['saldo_actual', 'saldo_con_fondos', 'saldo_fondos'];
    protected $connection = "inquilino";
    protected $table = "cuentas";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'banco_id',
        'numero',
        'saldo_actual',
        'ind_activa'
    ];

    public static function getCampoOrder()
    {
        return "numero";
    }

    public static function getWhereCondition()
    {
        return static::whereIndActiva(true);
    }

    public function getPrettyName()
    {
        return "Cuenta";
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function getNombreAttribute()
    {
        return $this->banco->nombre . '-' . $this->numero;
    }

    public function getSaldoFondosAttribute()
    {
        return $this->fondos()->sum('saldo_actual');
    }

    public function fondos()
    {
        return $this->hasMany(Fondo::class)->whereIndCajaChica(false);
    }

    public function getSaldoConFondosAttribute()
    {
        return $this->saldo_actual + $this->saldo_fondos;
    }

    public function buscarMovimiento($referencia, $tipo, $unico = true)
    {
        $collection = $this->movimientos()->whereReferencia($referencia)->whereTipoMovimiento($tipo)->get();
        if ($collection->count() == 0) {
            $collection = $this->movimientosFondos()->whereReferencia($referencia)->whereTipoMovimiento($tipo)->get();
            //Fix de laravel me jode la vaina
            $collection->each(function ($mov) {
                $mov->cuenta_id = null;
            });
        }
        if ($unico) {
            return ($collection->count() == 0) ? new MovimientosCuenta() : $collection->first();
        }

        return $collection;
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientosCuenta::class)->orderBy('fecha_pago', 'DESC');
    }

    public function movimientosFondos()
    {
        $query = MovimientosCuenta::join('fondos', 'movimientos_cuenta.fondo_id', '=', 'fondos.id')
            ->where('fondos.cuenta_id', $this->id)->select(['movimientos_cuenta.id'])->get();

        return MovimientosCuenta::whereIn('id', $query->pluck('id')->all());
    }

    public function scopeActivas($query)
    {
        return $query->whereIndActiva(true);
    }

    public function retirar($monto, $referencia, $comentario, $clasificacion = null)
    {
        $movimiento = new MovimientosCuenta();
        $movimiento->cuenta()->associate($this);
        $movimiento->clasificacion()->associate($clasificacion);
        $movimiento->monto_egreso = $monto;
        $movimiento->fecha_factura = Carbon::now();
        $movimiento->estatus = "PEN";
        $movimiento->comentarios = $comentario;
        $movimiento->referencia = $referencia;
        $movimiento->tipo_movimiento = "ND";
        $movimiento->forma_pago = "banco";
        $movimiento->numero_factura = "N/A";
        $movimiento->save();

        return $movimiento;
    }

    protected function getPrettyFields()
    {
        return [
            'banco_id' => 'Banco',
            'numero' => 'Número de cuenta',
            'saldo_actual' => 'Saldo Real',
            'saldo_con_fondos' => 'Saldo',
            'ind_activa' => '¿Activa?'
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
            'banco_id' => 'required|integer',
            'numero' => 'required|size:20',
            'saldo_actual' => 'required',
        ];
    }
}
