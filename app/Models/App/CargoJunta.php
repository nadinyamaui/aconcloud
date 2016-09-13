<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\CargoJunta
 *
 * @property integer $id
 * @property string $nombre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\CargoJunta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\CargoJunta whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\CargoJunta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\CargoJunta whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class CargoJunta extends BaseModel
{

    protected $table = "cargos_junta";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public function getPrettyName()
    {
        return "Cargos de la junta de condominio";
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Cargo de la junta',
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
            'nombre' => 'required',
        ];
    }
}
