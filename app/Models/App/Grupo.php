<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\Grupo
 *
 * @property integer $id
 * @property string $nombre
 * @property string $codigo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Grupo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Grupo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Grupo whereCodigo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Grupo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Grupo whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Grupo extends BaseModel
{

    protected $table = "grupos";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'codigo'
    ];

    public static function getWhereCondition()
    {
        if (User::esAdmin()) {
            return null;
        } else {
            return static::where('codigo', '<>', 'admin');
        }
    }

    public function getPrettyName()
    {
        return "grupos";
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'nombre',
            'codigo' => 'codigo',
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
            'codigo' => 'required',
        ];
    }
}
