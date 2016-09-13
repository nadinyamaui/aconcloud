<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\InquilinoUser
 *
 * @property integer $id
 * @property integer $inquilino_id
 * @property integer $user_id
 * @property integer $grupo_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\App\Inquilino $inquilino
 * @property-read \App\Models\App\User $user
 * @property-read \App\Models\App\Grupo $grupo
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\InquilinoUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\InquilinoUser whereInquilinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\InquilinoUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\InquilinoUser whereGrupoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\InquilinoUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\InquilinoUser whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class InquilinoUser extends BaseModel
{

    protected $table = "inquilino_user";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'inquilino_id',
        'user_id',
        'grupo_id',
    ];

    /**
     * Define una relación pertenece a Inquilino
     * @return Inquilino
     */
    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class);
    }

    /**
     * Define una relación pertenece a User
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define una relación pertenece a Grupo
     * @return Grupo
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function getPrettyName()
    {
        return "inquilino_user";
    }

    protected function getPrettyFields()
    {
        return [
            'inquilino_id' => 'Inquilino',
            'user_id'      => 'Usuario',
            'grupo_id'     => 'Grupo',
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
            'inquilino_id' => 'required|integer',
            'user_id'      => 'required|integer',
            'grupo_id'     => 'required|integer',

        ];
    }


}
