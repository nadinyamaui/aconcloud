<?php

namespace App\Modules\Asambleas;

use App\Models\App\User;
use App\Models\BaseModel;
use App\Modules\Asambleas\Jobs\AsambleaEnVivo;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquilino\MensajeChat;

class Asistente extends BaseModel
{
    protected $connection = "inquilino";
    protected $table = "asambleas_asamblea_user";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asamblea()
    {
        return $this->belongsTo(Asamblea::class);
    }

    public function getPrettyName()
    {
        return "Asistentes";
    }

    public function getIndAsistioBotonAttribute()
    {
        if(User::esJunta(true)){
            return '<div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default boton-asamblea-asistencia '.($this->ind_asistio ? 'active':'').'" data-id="'.$this->id.'">
                <input class="form-control" data-id="'.$this->id.'" id="ind_asistio" '.($this->ind_asistio ? 'checked="checked"':'').' name="ind_asistio" type="radio" value="1"> Si
            </label>
            <label class="btn btn-default boton-asamblea-asistencia '.($this->ind_asistio ? '':'active').'" data-id="'.$this->id.'">
                <input class="form-control boton-asamblea-asistencia" id="ind_asistio" '.($this->ind_asistio ? '':'checked="checked"').' name="ind_asistio" type="radio" value="0"> No
            </label>
        </div>';
        }else{
            return $this->getValueAt('ind_asistio');
        }
    }

    protected function getPrettyFields()
    {
        return [
            'nombre'=>'Usuario',
            'apellido'=>'Apellido',
            'hora_ingreso'=>'Hora de ingreso',
            'ind_asistio_boton'=>'&iquest;Asisti&oacute;?'
        ];
    }

    protected function getRules()
    {
        return [];
    }

}
