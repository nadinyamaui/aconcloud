<?php namespace App\Modules\Propuestas;

use App\Models\App\User;
use App\Models\BaseModel;
use App\Models\Inquilino\Vivienda;

/**
 * App\Modules\Propuestas\Votacion
 *
 * @property-read Propuesta $propuesta
 * @property-read User $user
 * @property-read Vivienda $vivienda
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property-read mixed $nombre_votante
 * @property-read mixed $nombre_apartamento
 * @property-read mixed $nombre_propietario
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Propuestas\Votacion filtrar($filtro)
 */
class Votacion extends BaseModel
{

    protected $table = "propuestas_votaciones";
    protected $connection = "inquilino";

    public function scopeFiltrar($query, $filtro)
    {
        if (isset($filtro['solo_pendiente'])) {
            $query->whereIndCerrado(false);
        } else if (isset($filtro['solo_cerradas'])) {
            $query->whereIndCerrado(true);
        }
        return $query;
    }

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vivienda()
    {
        return $this->belongsTo(Vivienda::class);
    }

    public function getPrettyName()
    {
        return "Votacion";
    }

    public function getNombreVotanteAttribute()
    {
        return $this->user->nombre_completo;
    }

    public function getNombreApartamentoAttribute()
    {
        return $this->vivienda->nombre;
    }

    public function getNombrePropietarioAttribute()
    {
        if($this->vivienda->propietario){
            return $this->vivienda->propietario->nombre_completo;
        }
    }

    protected function getPrettyFields()
    {
        return [
            'propuesta_id'   => 'Propuesta',
            'vivienda_id'    => 'Vivienda',
            'user_id'        => 'Usuario',
            'nombre_votante' => 'Votante',
            'nombre_apartamento' => 'Apartamento',
            'nombre_propietario' => 'Propietario',
            'ind_en_acuerdo' => '¿De acuerdo con la propuesta?',
            'comentarios' => 'Comentarios adicionales',
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
            'propuesta_id'   => 'required',
            'vivienda_id'    => 'required',
            'user_id'        => '',
            'ind_en_acuerdo' => '',
            'comentarios'    => '',
        ];
    }
}
