<?php namespace App\Models\App;

use App\Models\BaseModel;

/**
 * App\Models\App\SmsEnviado
 *
 * @property integer $id
 * @property integer $inquilino_id
 * @property integer $destinatario_id
 * @property string $mensaje
 * @property boolean $ind_enviado
 * @property string $error
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $ind_reservado
 * @property-read Inquilino $inquilino
 * @property-read User $destinatario
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereInquilinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereDestinatarioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereMensaje($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereIndEnviado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereError($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\SmsEnviado whereIndReservado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class SmsEnviado extends BaseModel
{

    protected $table = "sms_enviados";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'inquilino_id',
        'destinatario_id',
        'mensaje'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->ind_enviado = false;
        $this->ind_reservado = false;
    }

    public static function encolar($mensaje, User $destinatario)
    {
        if ($destinatario->telefono_celular != "") {
            SmsEnviado::create([
                'mensaje'         => $mensaje,
                'destinatario_id' => $destinatario->id,
                'inquilino_id'    => Inquilino::$current->id,
            ]);
        }
    }

    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class, 'inquilino_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function reservar()
    {
        $this->ind_reservado = true;
        $this->save();
    }

    public function enviado()
    {
        $this->ind_enviado = true;
        $this->save();
    }

    public function error($error)
    {
        $this->ind_enviado = true;
        $this->error = $error;
        $this->save();
    }

    public function getPrettyName()
    {
        return "Mensaje de texto";
    }

    protected function getPrettyFields()
    {
        return [
            'inquilino_id'    => 'Inquilino',
            'destinatario_id' => 'Destinatario',
            'mensaje'         => 'Mensaje',
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
            'inquilino_id'    => 'required',
            'destinatario_id' => 'required',
            'mensaje'         => 'required|max:160',
        ];
    }
}
