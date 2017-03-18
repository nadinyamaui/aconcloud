<?php namespace App\Models\Inquilino;

use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\BaseModel;

/**
 * App\Models\Inquilino\Vivienda
 *
 * @property integer $id
 * @property integer $tipo_vivienda_id
 * @property string $numero_apartamento
 * @property integer $piso
 * @property string $torre
 * @property string $comentarios
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Inquilino\TipoVivienda $tipoVivienda
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\App\User[] $usuarios
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereTipoViviendaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereNumeroApartamento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda wherePiso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereTorre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereComentarios($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\MovimientoCuenta[] $gastos
 * @property-read mixed $nombre
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property float $saldo_actual
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda whereSaldoActual($value)
 * @property integer $propietario_id
 * @property-read \App\Models\App\User $propietario
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Vivienda wherePropietarioId($value)
 * @property-read mixed $saldo_deudor
 * @property-read mixed $saldo_a_favor
 */
class Vivienda extends BaseModel
{

    protected static $decimalFields = ['saldo_actual', 'saldo_deudor', 'saldo_a_favor'];
    protected $connection = "inquilino";
    protected $table = "viviendas";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'tipo_vivienda_id',
        'numero_apartamento',
        'piso',
        'torre',
        'comentarios',
        'saldo_actual',
        'propietario_id',
        'saldo_deudor',
        'saldo_a_favor'
    ];

    protected $appends = ['saldo_deudor', 'saldo_a_favor'];

    public static function getCampoOrder()
    {
        return 'numero_apartamento';
    }

    public function getPrettyName()
    {
        return "viviendas";
    }

    /**
     * Define una relación pertenece a TipoVivienda
     * @return TipoVivienda
     */
    public function tipoVivienda()
    {
        return $this->belongsTo(TipoVivienda::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, Inquilino::$databaseName . '.user_vivienda')->withTimestamps();
    }

    public function propietario()
    {
        return $this->belongsTo(User::class);
    }

    public function getNombreAttribute()
    {
        $str = "Apartamento " . $this->numero_apartamento . ', Piso ' . $this->piso;
        if ($this->torre != "") {
            $str .= ', Torre ' . $this->torre;
        }

        return $str;
    }

    public function getSaldoDeudorAttribute()
    {
        return $this->saldo_actual > 0 ? $this->saldo_actual : 0;
    }

    public function getSaldoAFavorAttribute()
    {
        return $this->saldo_actual < 0 ? abs($this->saldo_actual) : 0;
    }

    public function setSaldoAFavorAttribute($value)
    {
        if ($value != 0) {
            $this->saldo_actual = $value * -1;
        }
    }

    public function setSaldoDeudorAttribute($value)
    {
        if ($value != 0) {
            $this->saldo_actual = $value;
        }
    }

    public function calcularMontoNoComun(CorteRecibo $corte)
    {
        $monto = 0;
        $gastos = $this->gastos()->whereMonthYear('fecha_pago', $corte->mes, $corte->ano)->get();
        $gastos->each(function ($gasto) use (&$monto) {
            $montoGasto = $gasto->monto_egreso;
            $monto += $montoGasto / ($gasto->viviendas()->count());
        });

        return $monto;
    }

    public function gastos()
    {
        return $this->belongsToMany(
            'App\Models\Inquilino\MovimientosCuenta',
            'gasto_vivienda',
            'vivienda_id',
            'gasto_id'
        )
            ->withTimestamps();
    }

    public function gastosNoComunes(CorteRecibo $corte)
    {
        $gastos = $this->gastos()->whereMonthYear('fecha_pago', $corte->mes, $corte->ano)->get();
        $gastos->each(function ($gasto) {
            $gasto->monto_egreso = $gasto->monto_egreso / ($gasto->viviendas()->count());
        });

        return $gastos;
    }

    public function listaUsuarios()
    {
        $ids = $this->usuarios->lists('id')->all();
        $ids = array_unique(array_merge([$this->propietario_id], $ids));

        return User::findMany($ids);
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
            'tipo_vivienda_id' => 'required|integer',
            'numero_apartamento' => 'required',
            'piso' => '',
            'torre' => '',
            'comentarios' => '',
            'saldo_actual' => 'required',
            'propietario_id' => '',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'tipo_vivienda_id' => 'Tipo de vivienda',
            'numero_apartamento' => 'N° de Vivienda',
            'piso' => 'Piso',
            'torre' => 'Torre',
            'comentarios' => 'Comentarios Adicionales',
            'usuarios' => 'Residentes',
            'saldo_actual' => 'Saldo actual',
            'nombre' => 'Vivienda',
            'propietario_id' => 'Propietario',
            'saldo_deudor' => 'Saldo deudor',
            'saldo_a_favor' => 'Saldo a favor',
        ];
    }
}
