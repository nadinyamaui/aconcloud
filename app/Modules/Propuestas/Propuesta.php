<?php namespace App\Modules\Propuestas;

use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\BaseModel;
use App\Models\Inquilino\Archivo;
use App\Models\Inquilino\MensajeChat;
use App\Modules\Asambleas\Asamblea;
use App\Modules\Comentarios\Comentario;
use App\Modules\Propuestas\Jobs\PropuestaCerrada;
use App\Modules\Propuestas\Jobs\PropuestaEnVotacion;
use App\Modules\Propuestas\Jobs\RecordarVotoVecinos;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;

/**
 * App\Modules\Propuestas\Propuesta
 *
 * @property-read User $autor
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $autorizados
 * @property-read \Illuminate\Database\Eloquent\Collection|Comentario[] $comentarios
 * @property-read \Illuminate\Database\Eloquent\Collection|Archivo[] $archivos
 * @property-read \Illuminate\Database\Eloquent\Collection|MensajeChat[] $mensajesChat
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Propuestas\Propuesta aplicarFiltro($texto)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property-read mixed $total_votantes
 * @property-read \Illuminate\Database\Eloquent\Collection|Votacion[] $votaciones
 * @property-read mixed $votantes_pendientes
 * @property-read mixed $votos_a_favor
 * @property-read mixed $votos_en_contra
 * @property-read mixed $total_votantes_pendientes
 * @property-read mixed $total_votos_a_favor
 * @property-read mixed $total_votos_en_contra
 */
class Propuesta extends BaseModel
{
    use DispatchesJobs;

    protected $table = "propuestas";
    protected $connection = "inquilino";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'titulo',
        'propuesta',
        'autor_id',
        'fecha_cierre',
        'ind_enviar_sms',
        'ind_enviar_email'
    ];

    protected static $estatusArray = [
        'abierta' => 'Abierta',
        'en_discusion' => 'En discusión',
        'en_votacion' => 'En proceso de votacion',
        'cerrada' => 'Cerrada',
    ];

    protected $dates = ['fecha_cierre'];

    public function autor()
    {
        return $this->belongsTo(User::class);
    }

    public function asamblea()
    {
        return $this->belongsTo(Asamblea::class);
    }

    public function autorizados()
    {
        return $this->belongsToMany(User::class, Inquilino::$databaseName . '.propuesta_user');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'item')->orderBy("created_at", "desc");
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'item')->orderBy("created_at", "desc");
    }

    public function mensajesChat()
    {
        return $this->morphMany(MensajeChat::class, 'item')->orderBy("created_at")->with('autor');
    }

    public function scopeAplicarFiltro($query, $texto)
    {
        if ($texto != "") {
            $query->where('titulo', 'LIKE', '%' . $texto . '%');
        }

        return $query;
    }

    public function validate()
    {
        if (parent::validate()) {
            if ($this->fecha_cierre->lt(Carbon::now()) && !$this->isDirty('estatus') && !$this->isDirty('asamblea_id')) {
                $this->addError('fecha_cierre', 'La fecha de cierre debe ser mayor que la fecha de publicación');
            }
        }

        return !$this->hasErrors();
    }

    public function getPrettyName()
    {
        return "Propuesta";
    }

    public function getDefaultValues()
    {
        return [
            'autor_id' => \Auth::id(),
        ];
    }

    public function puedeEditar()
    {
        return $this->estaAutorizado() && $this->estatus == "abierta";
    }

    public function puedeVerVotacion()
    {
        return in_array($this->estatus, ['en_votacion', 'cerrada']);
    }

    public function enVotacion()
    {
        if ($this->puedeActivarVotacion()) {
            $this->estatus = "en_votacion";
            $this->save();

            $this->dispatch(new PropuestaEnVotacion($this->id, auth()->id()));
        }
    }

    public function cerrarVotacion()
    {
        if ($this->puedeCerrarVotacion()) {
            $this->estatus = "cerrada";
            $this->save();

            $this->dispatch(new PropuestaCerrada($this->id));
        }
    }

    public function recordarVecinos()
    {
        if ($this->puedeNotificarVecinos()) {
            $this->dispatch(new RecordarVotoVecinos($this->id));
        }
    }

    public function puedeActivarVotacion()
    {
        return $this->estaAutorizado() && $this->estatus == "en_discusion";
    }

    public function puedeNotificarVecinos()
    {
        return $this->estaAutorizado() && $this->estatus == "en_votacion";
    }

    public function puedeCerrarVotacion()
    {
        return $this->estaAutorizado() && $this->estatus == "en_votacion";
    }

    public function estaAutorizado()
    {
        return in_array(Auth::id(), $this->autorizados->lists('id')->all()) || !$this->exists || User::esAdmin();
    }

    public function puedeVotar()
    {
        return $this->estatus == "en_votacion";
    }

    public function getTotalVotantesAttribute()
    {
        return $this->votaciones()->count();
    }

    public function votaciones()
    {
        return $this->hasMany(Votacion::class, 'propuesta_id');
    }

    public function getVotantesPendientesAttribute()
    {
        return $this->votaciones()->whereIndCerrado(false);
    }

    public function getVotosAFavorAttribute()
    {
        return $this->votaciones()->whereIndEnAcuerdo(true);
    }

    public function getVotosEnContraAttribute()
    {
        return $this->votaciones()->whereIndEnAcuerdo(false);
    }

    public function getTotalVotantesPendientesAttribute()
    {
        return $this->votantes_pendientes->count();
    }

    public function getTotalVotosAFavorAttribute()
    {
        return $this->votos_a_favor->count();
    }

    public function getTotalVotosEnContraAttribute()
    {
        return $this->votos_en_contra->count();
    }

    public function getDecisionDisplayAttribute()
    {
        if($this->total_votos_a_favor > $this->total_votos_en_contra){
            return "APROBADA";
        }else if($this->total_votos_en_contra >= $this->total_votos_a_favor){
            return "RECHAZADA";
        }
    }

    public function getDecisionColor()
    {
        if($this->total_votos_a_favor > $this->total_votos_en_contra){
            return "success";
        }else if($this->total_votos_en_contra >= $this->total_votos_a_favor){
            return "danger";
        }
    }

    public function getEstatusColor()
    {
        $colors = [
            'abierta'=>'primary',
            'en_discusion'=>'danger',
            'en_votacion'=>'warning',
            'cerrada'=>'success',
        ];

        return $colors[$this->estatus];
    }

    public function enDiscusion()
    {
        $this->estatus = "en_discusion";
        $this->save();
    }

    protected function getPrettyFields()
    {
        return [
            'titulo' => 'Titulo de la propuesta',
            'propuesta' => 'Detalles de la propuesta',
            'autor_id' => 'Autor de la propuesta',
            'fecha_cierre' => 'Fecha de cierre',
            'autorizados' => 'Autorizados a modificar la propuesta',
            'ind_enviar_sms' => 'Enviar SMS a todos los vecinos con la propuesta',
            'ind_enviar_email' => 'Enviar la propuesta por correo a todos los vecinos'
        ];
    }

    protected function getRules()
    {
        return [
            'titulo' => 'required',
            'propuesta' => 'required',
            'autor_id' => 'required',
            'fecha_cierre' => 'required',
        ];
    }

    public static function getCampoCombo()
    {
        return "titulo";
    }

    public static function getWhereCondition()
    {
        return self::whereEstatus("abierta");
    }
}
