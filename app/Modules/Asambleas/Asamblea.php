<?php

namespace App\Modules\Asambleas;

use App\Models\App\User;
use App\Models\BaseModel;
use App\Modules\Asambleas\Jobs\AsambleaEnVivo;
use App\Modules\Asambleas\Jobs\AsambleaTerminada;
use App\Modules\Propuestas\Propuesta;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquilino\MensajeChat;

/**
 * App\Modules\Asambleas\Asamblea
 *
 * @property-read User $autor
 * @property-read mixed $youtube_embed_link
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Asambleas\Asamblea aplicarFiltro($texto)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property-read \Illuminate\Database\Eloquent\Collection|MensajeChat[] $mensajesChat
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $asistentes
 */
class Asamblea extends BaseModel
{
    use DispatchesJobs;

    protected $connection = "inquilino";
    protected $table = "asambleas_asambleas";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'titulo',
        'detalles',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'youtube_link',
        'ind_enviar_email',
        'ind_enviar_sms'
    ];

    protected static $estatusArray = [
        'pendiente' => 'Pendiente',
        'en_curso' => 'En curso',
        'terminada' => 'Terminada',
    ];

    protected $dates = ['fecha'];

    public function autor()
    {
        return $this->belongsTo(User::class);
    }

    public function asistentes()
    {
        return $this->hasMany(Asistente::class);
    }

    public function propuestas()
    {
        return $this->hasMany(Propuesta::class);
    }

    public function mensajesChat()
    {
        return $this->morphMany(MensajeChat::class, 'item')->orderBy("created_at")->with('autor');
    }

    public function getPrettyName()
    {
        return "Asambleas";
    }

    public function scopeAplicarFiltro($query, $texto)
    {
        if ($texto) {
            $query->where('titulo', 'LIKE', '%' . $texto . '%');
        }

        return $query;
    }

    public function getDefaultValues()
    {
        return [
            'autor_id' => \Auth::id(),
            'estatus' => 'pendiente',
        ];
    }

    public function estaAutorizado()
    {
        return !$this->exists || User::esAdmin() || $this->autor_id == Auth::id();
    }

    public function getYoutubeEmbedLinkAttribute()
    {
        if ($this->youtube_link != "") {
            $url = $this->youtube_link;
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
            return "https://www.youtube.com/embed/" . $matches[1];
        }
        return '';
    }

    public function getFechaInicio()
    {
        $horaInicio = explode(':', $this->hora_inicio);
        return $this->fecha->copy()->setTime($horaInicio[0], $horaInicio[1]);
    }

    public function getFechaFin()
    {
        $horaFin = explode(':', $this->hora_fin);
        return $this->fecha->copy()->setTime($horaFin[0], $horaFin[1]);
    }

    public function sePuedeComenzar()
    {
        return $this->youtube_embed_link != "";
    }

    public function estaRetrasada()
    {
        $hoy = Carbon::now();
        $fecha_inicio = $this->getFechaInicio();

        if ($hoy->gt($fecha_inicio) && !$this->sePuedeComenzar() && $this->estatus == "pendiente") {
            return true;
        }
        return false;
    }

    public function puedeEnCurso()
    {
        $hoy = Carbon::now();
        $fecha_inicio = $this->getFechaInicio();

        if ($hoy->gt($fecha_inicio) && $this->sePuedeComenzar() && $this->estatus == "pendiente" && $this->estaAutorizado()) {
            return true;
        }
        return false;
    }

    public function puedeEliminar()
    {
        return $this->estatus == "pendiente";
    }

    public function puedeEditar()
    {
        return in_array($this->estatus, ['pendiente', 'en_curso']);
    }

    public function puedeTerminar()
    {
        return $this->estatus == "en_curso";
    }

    public function comenzar()
    {
        if ($this->puedeEnCurso()) {
            $this->estatus = "en_curso";
            $this->save();

            $this->dispatch(new AsambleaEnVivo($this->id));

            return true;
        }

        return false;
    }

    public function terminada()
    {
        if ($this->puedeTerminar()) {
            $this->estatus = "terminada";
            $this->save();

            $this->dispatch(new AsambleaTerminada($this->id));

            return true;
        }

        return false;
    }

    public function validate()
    {
        if (parent::validate()) {
            $hoy = Carbon::now();
            $fechaInicio = $this->getFechaInicio();
            $fechaFin = $this->getFechaFin();
            if ($fechaInicio->gte($fechaFin)) {
                $this->addError('hora_inicio', 'La hora de inicio debe ser menor que la hora de finalización');
            }

            if ($fechaInicio->addDay()->lt($hoy)) {
                $this->addError('fecha', 'El evento debe ser planeado con al menos 24 horas de antelación');
            }

            if ($this->isDirty(['fecha', 'hora_inicio', 'hora_fin']) && $this->estatus != "pendiente") {
                $this->addError(['fecha', 'hora_inicio', 'hora_fin'], 'No puedes cambiar esto porque la asamblea esta en curso');
            }
        }

        return !$this->hasErrors();
    }

    public function getEstatusColor()
    {
        $colors = [
            'pendiente' => 'primary',
            'en_curso' => 'danger',
            'terminada' => 'success',
        ];

        return $colors[$this->estatus];
    }

    public function asistente()
    {
        $user = auth()->user();
        $record = $this->asistentes()->whereUserId($user->id)->first();

        if (is_object($record) && $record->ind_asistio == false) {
            $record->ind_asistio = true;
            $record->hora_ingreso = Carbon::now()->format('H:i');
            $record->save();
        }
    }

    public function getTotalAsistentesAttribute()
    {
        return $this->asistentes()->whereIndAsistio(true)->count();
    }

    public function getTotalNoAsistentesAttribute()
    {
        return $this->asistentes()->whereIndAsistio(false)->count();
    }

    protected function getPrettyFields()
    {
        return [
            'titulo'       => 'Titulo',
            'fecha'        => 'Fecha del evento',
            'hora_inicio'  => 'Hora de inicio',
            'hora_fin'     => 'Hora de finalización',
            'status'       => 'Status',
            'propuestas'=>'Propuestas a discutir',
            'youtube_link' => 'Link al evento',
            'ind_enviar_sms' => 'Enviar SMS a todos los vecinos con una notificación de la asamblea',
            'ind_enviar_email' => 'Enviar una notificación a los vecinos por correo'
        ];
    }

    protected function getRules()
    {
        return [
            'titulo'      => 'required',
            'fecha'       => 'required',
            'hora_inicio' => 'required',
            'hora_fin'    => 'required',
        ];
    }

    public function cambiarEstatus()
    {
        //Se le cambia el estatus a las propuestas seleccionadas
        $propuestas = $this->propuestas;
        $propuestas->each(function (Propuesta $propuesta) {
            $propuesta->enDiscusion();
        });
    }
}
