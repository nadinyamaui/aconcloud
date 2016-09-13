<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\Modulo
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property float $costo_mensual
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereCostoMensual($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property string $codigo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\App\Inquilino[] $inquilinos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Modulo whereCodigo($value)
 */
class Modulo extends BaseModel
{

    protected static $decimalFields = ['costo_mensual'];
    protected $table = "modulos";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'costo_mensual',
        'codigo'
    ];

    public function inquilinos()
    {
        return $this->belongsToMany(Inquilino::class);
    }

    public function getPrettyName()
    {
        return "Modulo";
    }

    protected function getPrettyFields()
    {
        return [
            'codigo'        => 'Código interno del módulo',
            'nombre'        => 'Nombre del módulo',
            'descripcion'   => 'Descripción',
            'costo_mensual' => 'Costo Mensual',
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
            'codigo'        => 'required|max:20',
            'nombre'        => 'required|max:50',
            'descripcion'   => 'required',
            'costo_mensual' => 'required',
        ];
    }
}
