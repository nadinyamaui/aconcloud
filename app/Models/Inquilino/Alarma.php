<?php namespace App\Models\Inquilino;

use App\Jobs\AlarmaCreada;
use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\BaseModel;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * App\Models\Inquilino\Alarma
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read \ $item
 * @property-read mixed $atender_link
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Alarma filtrarPorUsuario($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Alarma ordenar()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Alarma extends BaseModel
{

    use DispatchesJobs;
    protected $connection = "inquilino";
    protected $table = "alarmas";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'fecha_vencimiento',
        'fecha_advertencia',
        'nombre',
        'descripcion',
        'ind_atendida'
    ];

    protected $dates = ['fecha_vencimiento', 'fecha_advertencia'];

    public function getPrettyName()
    {
        return "Alarma";
    }

    public function users()
    {
        return $this->belongsToMany(User::class, Inquilino::$databaseName . '.alarma_user');
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function notificar()
    {
        $this->dispatch(new AlarmaCreada($this->id));
    }

    public function getAtenderLinkAttribute()
    {
        return link_to("alarmas/redirigir/" . $this->id, "Atender");
    }

    public function scopeFiltrarPorUsuario($query, $id)
    {
        $query->join('alarma_user', 'alarmas.id', '=', 'alarma_user.alarma_id')
            ->where('alarma_user.user_id', '=', $id);

        return $query;
    }

    public function scopeOrdenar($query)
    {
        return $query->orderBy('ind_atendida', 'DESC')->orderBy('id', 'DESC');
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
            'fecha_vencimiento' => 'required_if:ind_automatica,0',
            'fecha_advertencia' => 'required_if:ind_automatica,0',
            'nombre' => 'required',
            'descripcion' => '',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'fecha_vencimiento' => 'Fecha de vencimiento',
            'fecha_advertencia' => 'Fecha de notificación',
            'nombre' => 'Alarma',
            'descripcion' => 'Detalle',
            'ind_atendida' => '¿Atendida?',
            'atender_link' => 'Atender alarma',
        ];
    }
}
