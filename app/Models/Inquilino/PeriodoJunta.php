<?php namespace App\Models\Inquilino;

use App\Models\BaseModel;

/**
 * App\Models\Inquilino\PeriodoJunta
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|PeriodoJuntaUser[] $usuarios
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class PeriodoJunta extends BaseModel
{

    protected $connection = "inquilino";
    protected $table = "periodo_junta";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'fecha_desde',
        'fecha_hasta'
    ];

    protected $dates = ['fecha_desde', 'fecha_hasta'];

    public function usuarios()
    {
        return $this->hasMany(PeriodoJuntaUser::class, 'periodo_junta_id');
    }

    public function getPrettyName()
    {
        return "Periodo de la junta";
    }

    protected function getPrettyFields()
    {
        return [
            'fecha_desde' => 'Fecha desde',
            'fecha_hasta' => 'Fecha hasta',
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
        $rules = [
            'fecha_desde' => 'required',
            'fecha_hasta' => '',
        ];
        if (is_object($this->fecha_hasta)) {
            $rules['fecha_desde'] = 'required|before:' . $this->fecha_hasta;
        }

        return $rules;
    }
}
