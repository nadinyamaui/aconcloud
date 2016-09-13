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
 * @property string $titulo
 * @property string $descripcion
 * @property string $contenido
 * @property integer $tipo_ayuda_id
 * @property integer $autor_id
 * @property-read \App\Models\App\TipoAyuda $tipoAyuda
 * @property-read \App\Models\App\User $autor
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Ayuda whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Ayuda whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Ayuda whereContenido($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Ayuda whereTipoAyudaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Ayuda whereAutorId($value)
 * @method static \App\Models\App\Ayuda aplicarFiltro($texto)
 */
class Ayuda extends BaseModel
{

    protected $table = "ayudas";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'contenido',
        'tipo_ayuda_id',
        'autor_id'
    ];

    public function tipoAyuda()
    {
        return $this->belongsTo(TipoAyuda::class, 'tipo_ayuda_id');
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function scopeAplicarFiltro($query, $texto)
    {
        $query->join('tipo_ayudas', 'ayudas.tipo_ayuda_id', '=', 'tipo_ayudas.id');
        if ($texto != "") {
            $query->where(function ($query) use ($texto) {
                $query->where('titulo', 'LIKE', '%' . $texto . '%');
                $query->orWhere('descripcion', 'LIKE', '%' . $texto . '%');
                $query->orWhere('nombre', 'LIKE', '%' . $texto . '%');
            });
        }
        $query->select(['ayudas.*']);

        return $query;
    }

    public function getPrettyName()
    {
        return "Ayuda";
    }

    protected function getPrettyFields()
    {
        return [
            'titulo'        => 'Titulo',
            'descripcion'   => 'Descripción',
            'contenido'     => 'Contenido',
            'tipo_ayuda_id' => 'Tipo de ayuda',
            'autor_id'      => 'Autor',
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
            'titulo'        => 'required',
            'descripcion'   => 'required',
            'contenido'     => 'required',
            'tipo_ayuda_id' => 'required',
            'autor_id'      => 'required',
        ];
    }
}
