<?php namespace App\Models\Inquilino;

use App\Models\BaseModel;

/**
 * App\Models\Inquilino\TipoVivienda
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $cantidad_apartamentos
 * @property float $porcentaje_pago
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $total_porcentaje
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\TipoVivienda whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\TipoVivienda whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\TipoVivienda
 *     whereCantidadApartamentos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\TipoVivienda wherePorcentajePago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\TipoVivienda whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\TipoVivienda whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class TipoVivienda extends BaseModel
{

    public static $decimalPositions = 6;
    protected static $decimalFields = ['porcentaje_pago', 'total_porcentaje'];
    protected $connection = "inquilino";
    protected $table = "tipo_viviendas";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'cantidad_apartamentos',
        'porcentaje_pago',
    ];

    public static function verificarConfiguracion()
    {
        $all = static::all();
        $acum = 0;
        foreach ($all as $tipo) {
            $acum += $tipo->total_porcentaje;
        }
        $epsilon = 0.00001;

        return abs(100 - $acum) < $epsilon;
    }

    public static function crearViviendas()
    {
        if (Vivienda::count() > 0) {
            return;
        }
        $all = static::all();
        foreach ($all as $tipo) {
            $cantidadAptos = $tipo->cantidad_apartamentos;
            for ($i = 0; $i < $cantidadAptos; $i++) {
                $vivienda = Vivienda::create([
                    'tipo_vivienda_id'   => $tipo->id,
                    'numero_apartamento' => ($i + 1),
                    'saldo_actual'       => '0,00'
                ]);
                if ($vivienda->hasErrors()) {
                    dd($vivienda->getErrors());
                }
            }
        }
    }

    public static function generarCorte($mes, $ano)
    {
        $corte = CorteRecibo::generarCorte($mes, $ano);
        $tipos = TipoVivienda::all();
        foreach ($tipos as $tipo) {
            $tipo->monto_pagar = $corte->monto_total * $tipo->porcentaje_pago / 100;
        }

        return $tipos;
    }

    public function getTotalPorcentajeAttribute()
    {
        return round($this->porcentaje_pago * $this->cantidad_apartamentos, 6);
    }

    public function getPrettyName()
    {
        return "Tipo de vivienda";
    }

    protected function getPrettyFields()
    {
        return [
            'nombre'                => 'Nombre',
            'cantidad_apartamentos' => 'Cantidad de Apartamentos',
            'porcentaje_pago'       => '% de pago x Apartamento',
            'total_porcentaje'      => 'Total %'
        ];
    }

    protected function getRules()
    {
        return [
            'nombre'                => 'required',
            'cantidad_apartamentos' => 'required|integer',
            'porcentaje_pago'       => 'required',
        ];
    }
}
