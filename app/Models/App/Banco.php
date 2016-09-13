<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\Banco
 *
 * @property integer $id
 * @property string $nombre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Banco whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Banco whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Banco whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Banco whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Banco extends BaseModel
{

    protected $table = "bancos";
    protected $connection = "app";
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
        return "Banco";
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Nombre del banco',
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
