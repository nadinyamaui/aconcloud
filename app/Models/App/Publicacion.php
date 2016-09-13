<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\Publicacion
 *
 * @property integer $id
 * @property string $titulo
 * @property string $contenido
 * @property integer $autor_id
 * @property integer $inquilino_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Inquilino $inquilino
 * @property-read User $autor
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereContenido($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereAutorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereInquilinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Publicacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Publicacion extends BaseModel
{

    protected $table = "publicaciones";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'titulo',
        'contenido',
    ];

    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class);
    }

    public function getPrettyName()
    {
        return "Publicacion";
    }

    protected function getPrettyFields()
    {
        return [
            'titulo'       => 'Titulo',
            'contenido'    => 'Contenido',
            'autor_id'     => 'Autor',
            'inquilino_id' => 'Inquilino',
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
            'titulo'       => 'required',
            'contenido'    => 'required',
            'autor_id'     => 'required',
            'inquilino_id' => 'required',
        ];
    }
}
