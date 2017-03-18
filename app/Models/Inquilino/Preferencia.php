<?php namespace App\Models\Inquilino;

use App\Models\BaseModel;

/**
 * App\Models\Inquilino\Preferencia
 *
 * @property integer $id
 * @property string $variable
 * @property string $valor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Preferencia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Preferencia whereVariable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Preferencia whereValor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Preferencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Preferencia whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Preferencia extends BaseModel
{

    protected $connection = "inquilino";
    protected $table = "preferencias";

    protected $fillable = [
        'valor',
        'variable'
    ];

    public static function buscar($variable)
    {
        return Preferencia::whereVariable($variable)->first(['valor'])->valor;
    }

    public static function buscarPreferencias()
    {
        $preferencia = new Preferencia();
        $todas = Preferencia::all();
        foreach ($todas as $aux) {
            $preferencia->{$aux->variable} = $aux->valor;
        }

        return $preferencia;
    }

    public static function guardarTodas(array $items)
    {
        foreach ($items as $key => $item) {
            Preferencia::guardar($key, $item);
        }
    }

    public static function guardar($variable, $valor)
    {
        $preferencia = Preferencia::firstOrNew(compact('variable'));
        $preferencia->valor = $valor;
        $preferencia->save();
    }

    public function getPrettyName()
    {
        return "Configuracion";
    }

    protected function getPrettyFields()
    {
        return [
            'dia_corte_recibo'     => '¿Qué dia del mes es el corte de los recibos?',
            'ano_inicio'           => '¿Desde que año quieres guardar tu información?',
            'mes_inicio'           => '¿Desde que mes quieres guardar tu información?',
            'porcentaje_morosidad' => '¿Cuál es el porcentaje de morosidad mensual?',
            'inicio_morosidad'     => '¿A partir de cuantos recibos vencidos deseas aplicar intereses de mora?',
            'nota_en_recibo'     => '¿Que nota quieres poner en el recibo de condominio?',
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
            'variable' => 'required',
            'valor'    => 'required',
        ];
    }
}
