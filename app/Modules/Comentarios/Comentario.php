<?php
namespace App\Modules\Comentarios;

use App\Models\App\User;
use App\Models\BaseModel;

/**
 * App\Modules\Comentarios\Comentario
 *
 * @property-read \App\Models\App\User $autor
 * @property-read mixed $estatus_display
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property integer $id
 * @property integer $autor_id
 * @property integer $item_id
 * @property string $item_type
 * @property string $comentario
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereAutorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereItemType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereComentario($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Comentarios\Comentario whereUpdatedAt($value)
 * @property-read \ $item
 */
class Comentario extends BaseModel
{

    protected $connection = "inquilino";
    protected $table = "comentarios";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'autor_id',
        'item_id',
        'item_type',
        'comentario',
    ];

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function getPrettyName()
    {
        return "Comentarios";
    }

    protected function getPrettyFields()
    {
        return [
            'autor_id'   => 'Autor',
            'item_id'    => 'Item',
            'item_type'  => 'Tipo de comentario',
            'comentario' => 'Comentario',
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
            'autor_id'   => 'required',
            'item_id'    => '',
            'item_type'  => 'required',
            'comentario' => 'required',
        ];
    }

   public function puedeEliminar()
   {
       return User::esJunta(true) || $this->autor_id == auth()->id();
   }
}
