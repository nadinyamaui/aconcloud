<?php namespace App\Models\Inquilino;

use App\Models\App\CargoJunta;
use App\Models\App\User;
use App\Models\BaseModel;

/**
 * App\Models\Inquilino\PeriodoJuntaUser
 *
 * @property-read PeriodoJunta $periodoJunta
 * @property-read CargoJunta $cargoJunta
 * @property-read User $user
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class PeriodoJuntaUser extends BaseModel
{

    protected $connection = "inquilino";
    protected $table = "periodo_junta_user";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'periodo_junta_id',
        'user_id',
        'cargo_junta_id'
    ];

    public function getPrettyName()
    {
        return "Usuario al periodo";
    }

    public function periodoJunta()
    {
        return $this->belongsTo(PeriodoJunta::class);
    }

    public function cargoJunta()
    {
        return $this->belongsTo(CargoJunta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
            'periodo_junta_id' => 'required',
            'user_id'          => 'required',
            'cargo_junta_id'   => 'required',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'periodo_junta_id' => 'Periodo',
            'user_id'          => 'Usuario',
            'cargo_junta_id'   => 'Cargo que desempeña',
        ];
    }
}
