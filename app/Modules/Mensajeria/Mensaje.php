<?php
namespace App\Modules\Mensajeria;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Mensajeria\Mensaje
 *
 * @property integer $id
 * @property string $asunto
 * @property string $cuerpo
 * @property integer $destinatario_id
 * @property integer $remitente_id
 * @property boolean $ind_leido
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property boolean $ind_automatico
 * @property-read \App\Models\App\User $remitente
 * @property-read \App\Models\App\User $destinatario
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereAsunto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereCuerpo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereDestinatarioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereRemitenteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereIndLeido($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereIndAutomatico($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property boolean $ind_saliente
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Mensajeria\Mensaje whereIndSaliente($value)
 */
class Mensaje extends BaseModel
{

    use SoftDeletes;
    protected $connection = "inquilino";
    protected $table = "mensajeria_mensajes";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'asunto',
        'cuerpo',
        'cuerpo_sms',
        'destinatario_id',
        'remitente_id',
        'ind_automatico',
        'ind_sms'
    ];

    public static function enviarMensajes(array $data)
    {
        foreach ($data['destinatarios'] as $destinatario) {
            $mensaje = new Mensaje($data);
            $mensaje->remitente()->associate(\Auth::user());
            $mensaje->destinatario_id = $destinatario;
            $mensaje->save();
        }

        return $mensaje;
    }

    public function remitente()
    {
        return $this->belongsTo('App\Models\App\User');
    }

    public static function noLeidos($user_id)
    {
        return static::whereDestinatarioId($user_id)->whereIndSaliente(false)->whereIndLeido(false)->count();
    }

    public function destinatario()
    {
        return $this->belongsTo('App\Models\App\User');
    }

    public function leido()
    {
        $this->ind_leido = true;
        $this->save();
    }

    public function getPrettyName()
    {
        return "Mensaje";
    }

    protected function getPrettyFields()
    {
        return [
            'asunto'        => 'Asunto del mensaje',
            'cuerpo'        => 'Cuerpo del mensaje',
            'cuerpo_sms'    => 'Cuerpo del mensaje',
            'remitente_id'  => 'Remitente',
            'ind_leido'     => '¿Leido?',
            'destinatarios' => 'Destinatarios',
            'ind_sms'       => '¿Enviar como mensaje de texto?'
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
            'asunto'          => 'required',
            'cuerpo'          => 'required_if:ind_sms,0',
            'cuerpo_sms'      => 'required_if:ind_sms,1',
            'destinatario_id' => 'required',
            'remitente_id'    => 'required',
        ];
    }
}
