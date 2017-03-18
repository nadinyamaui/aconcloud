<?php

namespace App\Models\Inquilino;

use App\Jobs\AlarmaCreada;
use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\BaseModel;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * App\Models\Inquilino\Email
 *
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Email extends BaseModel
{
    protected $connection = "inquilino";
    protected $table = "emails";

    public function getPrettyName()
    {
        return "Emails enviados";
    }

    protected function getRules()
    {
        return [
            'destinatario' => 'required',
            'asunto' => 'required',
            'cuerpo' => 'required',
        ];
    }

    protected function getPrettyFields()
    {
        return [

        ];
    }

    public function enviado()
    {
        $this->ind_enviado = true;
        $this->save();
    }

    public static function encolar($view, $data, $asunto, $user)
    {
        $data['asunto'] = $asunto;

        $email = new Email();
        $email->asunto = $asunto;
        $email->cuerpo = utf8_encode(view($view, $data)->render());
        $email->destinatario = $user->email;
        $email->nombre_destinatario = $user->nombre_completo;
        $email->save();
    }
}
