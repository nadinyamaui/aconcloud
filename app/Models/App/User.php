<?php namespace App\Models\App;

use App\Helpers\Helper;
use App\Models\BaseModel;
use App\Models\Inquilino\Alarma;
use App\Models\Inquilino\Email;
use App\Models\Inquilino\Vivienda;
use App\Modules\Comentarios\Comentario;
use App\Modules\Mensajeria\Mensaje;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\App\User
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $email
 * @property string $password
 * @property boolean $ind_activo
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $inquilinos_count
 * @property-read \App\Models\App\InquilinoUser')->whereInquilinoId(Inquilino::$current->id $inquilino
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\App\InquilinoUser[] $inquilinos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Vivienda[] $viviendas
 * @property-read mixed $nombre_completo
 * @property-read mixed $grupo_activo
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereApellido($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereIndActivo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property boolean $ind_recibir_gastos_creados
 * @property boolean $ind_recibir_gastos_modificados
 * @property boolean $ind_recibir_ingresos_creados
 * @property boolean $ind_recibir_ingresos_modificados
 * @property-read mixed $codigo_grupo_activo
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereIndRecibirGastosCreados($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereIndRecibirGastosModificados($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereIndRecibirIngresosCreados($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereIndRecibirIngresosModificados($value)
 * @property boolean $ind_cambiar_password
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereIndCambiarPassword($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquilino\Comentario[] $comentarios
 * @property string $telefono_celular
 * @property string $telefono_otro
 * @property-read \Illuminate\Database\Eloquent\Collection|Mensaje[] $mensajesEntrantes
 * @property-read \Illuminate\Database\Eloquent\Collection|Mensaje[] $mensajesSalientes
 * @property-read \Illuminate\Database\Eloquent\Collection|Alarma[] $alarmas
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereTelefonoCelular($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\User whereTelefonoOtro($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|SmsEnviado[] $smsEnviados
 */
class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    protected $connection = "app";
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'token_autenticacion_en_dos_pasos', 'expiracion_token'];

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'remember_token',
        'password_confirmation',
        'telefono_celular',
        'telefono_otro',
        'ind_activo',
        'cedula',
        'ind_recibir_gastos_creados',
        'ind_recibir_gastos_modificados',
        'ind_recibir_ingresos_creados',
        'ind_recibir_ingresos_modificados',
        'ind_recibir_ingresos_modificados',
        'ind_autenticacion_en_dos_pasos',
    ];

    protected $appends = ['nombre_completo', 'ruta_imagen_perfil'];

    protected $dates = ['expiracion_token'];

    public static function updateCreate(array $values, $changePassword = true)
    {
        $user = User::findOrNew($values['id']);
        $auxPass = $user->password;
        $user->fill($values);
        $needHash = true;
        if ($user->password == "" && $user->id && $changePassword) {
            $needHash = false;
            $user->password = $auxPass;
            $user->password_confirmation = $auxPass;
        }
        if ($changePassword && $user->validatesPassword($needHash)) {
            if ($user->save()) {
                $user->registrarAsociaciones($values);
            }
        }

        if (!$changePassword) {
            $user->save();
        }

        return $user;
    }

    public function validatesPassword($hash = true)
    {
        $data = [
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ];
        $rules = [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
        $v = \Validator::make($data, $rules);
        $v->setAttributeNames($this->getPrettyFields());
        unset($this->attributes['password_confirmation']);
        if ($v->fails()) {
            $this->appendErrors($v->messages());

            return false;
        }
        if ($hash) {
            $this->password = \Hash::make($this->password);
        }

        return true;
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Correo',
            'password' => 'Contraseña',
            'password_confirmation' => 'Repetir Contraseña',
            'telefono_celular' => 'Teléfono Celular',
            'telefono_otro' => 'Otro teléfono celular',
            'cedula'=>'Cédula',
            'ind_activo' => '¿Activado?',
            'ind_recibir_gastos_creados' => '¿Recibir email al registrar un gasto?',
            'ind_recibir_gastos_modificados' => '¿Recibir email al modificar un gasto?',
            'ind_recibir_ingresos_creados' => '¿Recibir email al registrar un ingreso?',
            'ind_recibir_ingresos_modificados' => '¿Recibir email al registrar un ingreso?',
            'ind_autenticacion_en_dos_pasos' => '¿Autenticación en dos pasos?',
            'token_autenticacion_en_dos_pasos'=>'Código que recibiste en tu teléfono'
        ];
    }

    private function registrarAsociaciones($values)
    {
        if (isset($values['inquilino_user_id'])) {
            $this->inquilinos()->delete();
            $asociaciones = $values['inquilino_user_id'];
            foreach ($asociaciones as $key => $asociacion) {
                $inquilinoUser = new InquilinoUser();
                $inquilinoUser->user()->associate($this);
                $inquilinoUser->grupo_id = $values['grupo_id'][$key];
                $inquilinoUser->inquilino_id = $values['inquilino_id'][$key];
                $inquilinoUser->save();
            }
        } else {
            if (isset($values['grupo_id']) && is_numeric($values['grupo_id']) && (User::esAdmin() || $values['grupo_id'] != 1)) {
                $inquilinoUser = $this->inquilino;
                if (is_null($inquilinoUser)) {
                    $inquilinoUser = new InquilinoUser();
                    $inquilinoUser->user_id = $this->id;
                    $inquilinoUser->inquilino_id = Inquilino::$current->id;
                }
                $inquilinoUser->grupo_id = $values['grupo_id'];
                $inquilinoUser->save();
            }
        }
    }

    public function inquilinos()
    {
        return $this->hasMany(InquilinoUser::class);
    }

    public static function esAdmin()
    {
        return static::getCodigoGrupo() == "admin";
    }

    public static function getCodigoGrupo()
    {
        $user = auth()->user();

        if ($user == null) {
            return "";
        }

        return $user->codigo_grupo_activo;
    }

    public static function login($params)
    {
        $user = static::findByEmail($params["email"]);
        $pass = true;
        if (!is_object($user)) {
            $pass = 'Usuario o contraseña incorrecto';
        } else {
            if (!\Hash::check($params['password'], $user->password)) {
                $pass = 'Usuario o contraseña incorrecto';
            } else {
                if (!$user->ind_activo) {
                    $pass = 'Tu cuenta esta desactivada';
                } else {
                    if ($user->tieneAcceso(Inquilino::$current)) {
                        if ($user->ind_autenticacion_en_dos_pasos) {
                            return $user;
                        } else {
                            \Auth::login($user, true);
                        }
                    } else {
                        $pass = 'Algo anda mal, no vives en este edificio. ¿Seguro que tienes la dirección correcta?';
                    }
                }
            }
        }

        return $pass;
    }

    public static function findByEmail($email)
    {
        return User::whereEmail($email)->first();
    }

    public function tieneAcceso(Inquilino $inquilino)
    {
        return $this->inquilinos()->whereInquilinoId($inquilino->id)->count() == 1;
    }

    public static function getCampoCombo()
    {
        return "nombre_completo";
    }

    public static function getCampoOrder()
    {
        return "nombre";
    }

    public static function esPropietario($up = false)
    {
        if ($up) {
            return static::esJunta($up) || static::esPropietario(false);
        }

        return static::getCodigoGrupo() == "propietario";
    }

    public static function esJunta($up = false)
    {
        if ($up) {
            return static::esAdmin() || static::esJunta(false);
        }

        return static::getCodigoGrupo() == "junta";
    }

    public function getPrettyName()
    {
        return "Usuario";
    }

    public function inquilino()
    {
        return $this->hasOne(InquilinoUser::class)->whereInquilinoId(Inquilino::$current->id);
    }

    public function mensajesEntrantes()
    {
        return $this->hasMany(Mensaje::class, 'destinatario_id')->withTrashed();
    }

    public function mensajesSalientes()
    {
        return $this->hasMany(Mensaje::class, 'remitente_id')->withTrashed();
    }

    public function smsEnviados()
    {
        return $this->hasMany(SmsEnviado::class, 'destinatario_id')->withTrashed();
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getCodigoGrupoActivoAttribute()
    {
        return $this->inquilino->grupo->codigo;
    }

    public function getGrupoActivoAttribute()
    {
        return $this->inquilino->grupo->nombre;
    }

    public function cambiarPassword($password, $confirmation)
    {
        $this->password = $password;
        $this->password_confirmation = $confirmation;
        if ($this->validatesPassword(true)) {
            $this->ind_cambiar_password = false;
            $this->save();

            return true;
        }

        return false;
    }

    public function deleteFromAdministrator()
    {
        $inquilinos = Inquilino::all();
        $inquilinos->each([$this, 'borrarDataDelInquilino']);
        $this->inquilinos()->delete();

        return $this->delete();
    }

    public function deleteFromInquilino()
    {
        $this->borrarDataDelInquilino(Inquilino::$current);
        InquilinoUser::whereInquilinoId(Inquilino::$current->id)->whereUserId($this->id)->delete();

        return $this->delete();
    }

    public function borrarDataDelInquilino(Inquilino $inquilino)
    {
        Inquilino::setActivo($inquilino->host);
        $this->viviendas()->detach();
        $this->alarmas()->detach();
        if ($inquilino->tieneModulo('comentarios')) {
            $this->comentarios()->delete();
            $this->comentarios->each(function ($comentario) {
                $comentario->delete();
            });
        }
        if ($inquilino->tieneModulo('mensajeria')) {
            $this->mensajesEntrantes->each(function ($mensaje) {
                $mensaje->forceDelete();
            });
            $this->mensajesSalientes->each(function ($mensaje) {
                $mensaje->forceDelete();
            });
        }

        $this->smsEnviados()->whereInquilinoId($inquilino->id)->delete();
    }

    public function viviendas()
    {
        return $this->belongsToMany(Vivienda::class, Inquilino::$databaseName . '.user_vivienda')->withTimestamps();
    }

    public function viviendasPropietario()
    {
        return $this->hasMany(Vivienda::class, 'propietario_id');
    }

    public function alarmas()
    {
        return $this->belongsToMany(Alarma::class, Inquilino::$databaseName . '.alarma_user');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'autor_id');
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
            'nombre' => 'required',
            'apellido' => 'required',
            'cedula'=>'integer',
            'email' => 'required|unique:users,email,' . $this->id,
            'telefono_celular' => ['size:11', 'regex:/^[0-9]+$/'],
            'telefono_otro' => ['size:11', 'regex:/^[0-9]+$/'],
        ];
    }

    public function enviarCorreo($view, $data, $asunto)
    {
        if ($this->ind_activo) {
            Email::encolar($view, $data, $asunto, $this);
        }
    }

    public function enviarCodigoEnDosPasos()
    {
        $this->token_autenticacion_en_dos_pasos = strtolower(Str::random(6));
        $this->expiracion_token = Carbon::now()->addHour();
        $this->save();

        SmsEnviado::encolar("Usa este código para iniciar sesión: ".$this->token_autenticacion_en_dos_pasos, $this);
    }

    public function codigoValido($codigo)
    {
        $hoy = Carbon::now();
        return strtolower($this->token_autenticacion_en_dos_pasos) == strtolower($codigo) && $hoy->lt($this->expiracion_token);
    }

    public function getRutaImagenPerfilAttribute()
    {
        if (is_null($this->imagen_perfil)) {
            return url('uploads/default_images/none_big.jpg');
        } else {
            return url('uploads/'.Inquilino::$current->id.'/'.$this->imagen_perfil);
        }
    }

    public function uploadProfilePicture($file)
    {
        if ($file != null) {
            if ($this->validateImage($file)) {
                $olderPicture = $this->imagen_perfil;
                $this->imagen_perfil = Helper::uploadFileToStorage($file, 'local_public');
                if ($this->save()) {
                    //delete the older picture
                    if ($olderPicture != "" && Storage::disk('local_public')->exists($olderPicture)) {
                        Storage::disk('local_public')->delete($olderPicture);
                    }
                } else {
                    //Delete the uploaded picture
                    if ($this->imagen_perfil != "" && Storage::disk('local_public')->exists($this->imagen_perfil)) {
                        Storage::disk('local_public')->delete($this->imagen_perfil);
                    }
                }
            }
        } else {
            $this->addError("imagen_perfil", 'No seleccionaste ninguna imagen');
        }
    }
}
