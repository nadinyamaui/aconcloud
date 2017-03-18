<?php namespace App\Models\App;

use App\Exceptions\InquilinoNotFound;
use App\Models\BaseModel;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\TipoVivienda;
use App\Models\Inquilino\Vivienda;
use Caffeinated\Modules\Facades\Module;
use Config;
use DB;
use HTML;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * App\Models\App\Inquilino
 *
 * @property integer $id
 * @propery Inquilino $current
 * @property string $nombre
 * @property string $host
 * @property string $descripcion
 * @property string $email_administrador
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereHost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereEmailAdministrador($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\App\User[] $usuarios
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property boolean $ind_configurado
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereIndConfigurado($value)
 * @property string $token_acceso
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereTokenAcceso($value)
 * @property string $direccion
 * @method static \Illuminate\Database\Query\Builder|\App\Models\App\Inquilino whereDireccion($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\App\Modulo[] $modulos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\App\InquilinoUser[] $inquilinoUsuarios
 */
class Inquilino extends BaseModel
{
    /**
     * @var Inquilino
     */
    public static $current;
    public static $databaseName;
    protected $table = "inquilinos";
    protected $connection = "app";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'host',
        'descripcion',
        'email_administrador',
        'ind_configurado',
        'direccion',
        'rif'
    ];

    public static function setActivo($host)
    {
        static::$current = static::findByHost($host);
        if (is_null(static::$current)) {
            throw new InquilinoNotFound();
        }
        $inquilino_db = Config::get('database.connections.app.database') . '_' . static::$current->id;
        Inquilino::$databaseName = $inquilino_db;
        Config::set('database.connections.inquilino.database', $inquilino_db);
        $connection = DB::connection('inquilino');
        $connection->disconnect();
        $connection->reconnect();

        Config::set('app.url', static::$current->host);
        Config::set('filesystems.disks.local.root', storage_path('app/archivos/' . static::$current->id));
        Config::set('filesystems.disks.local_public.root', public_path('uploads/' . static::$current->id));
        HTML::activarInquilino();

        return static::$current;
    }

    public static function findByHost($host)
    {
        return static::whereHost($host)->first();
    }

    public function getPrettyName()
    {
        return "Inquilino";
    }

    public function instalar()
    {
        // Create the database if it doesn't exists
        $inquilino_db = Config::get('database.connections.app.database') . '_' . $this->id;
        Inquilino::$databaseName = $inquilino_db;
        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $inquilino_db);
        Config::set('database.connections.inquilino.database', $inquilino_db);
        DB::connection('inquilino')->setDatabaseName($inquilino_db);
        DB::connection('inquilino')->commit();
        DB::connection('inquilino')->reconnect();
        DB::connection('inquilino')->beginTransaction();
        Artisan::call(
            'migrate',
            ['--path' => 'database/migrations/inquilino', '--database' => 'inquilino', '--force' => 1]
        );

        //migrate modules
        $modulos = $this->modulos;
        $modulos->each(function ($modulo) {
            Artisan::call('module:migrate', ['slug' => $modulo->codigo]);
        });

        $pathForStorage = storage_path('app/archivos/' . $this->id);
        $pathForPublicUploads = public_path('uploads/' . $this->id);
        if (!File::exists($pathForStorage)) {
            File::makeDirectory($pathForStorage);
            File::put($pathForStorage.DIRECTORY_SEPARATOR.'.gitignore', '*'.PHP_EOL.'!.gitignore');
        }
        if (!File::exists($pathForPublicUploads)) {
            File::makeDirectory($pathForPublicUploads);
            File::put($pathForPublicUploads.DIRECTORY_SEPARATOR.'.gitignore', '*'.PHP_EOL.'!.gitignore');
        }
    }

    public function tieneModulo($codigo)
    {
        return $this->modulos()->whereCodigo($codigo)->count() > 0;
    }

    public function modulos()
    {
        return $this->belongsToMany(Modulo::class);
    }

    public function smsEnviados()
    {
        return $this->hasMany(SmsEnviado::class);
    }

    public function inquilinoUsuarios()
    {
        return $this->hasMany(InquilinoUser::class);
    }

    public function configurado()
    {
        $usuarios = $this->usuarios()->count();
        if ($usuarios == 0) {
            $this->addError('ind_configurado', 'Debes configurar al menos un usuario.');
        }
        $tipos = TipoVivienda::count();
        if ($tipos == 0) {
            $this->addError('ind_configurado', 'Debes configurar al menos un tipo de vivienda.');
        }
        $viviendas = Vivienda::count();
        if ($viviendas == 0) {
            $this->addError('ind_configurado', 'Debes configurar al menos una vivienda.');
        }
        $cuentas = Cuenta::count();
        if ($cuentas == 0) {
            $this->addError('ind_configurado', 'Debes configurar al menos una cuenta.');
        }
        $fondos = Fondo::count();
        if ($fondos == 0) {
            $this->addError('ind_configurado', 'Debes configurar al menos un fondo.');
        }
        $clasificaciones = ClasificacionIngresoEgreso::count();
        if ($clasificaciones == 0) {
            $this->addError('ind_configurado', 'Debes configurar al menos una clasificación de ingreso/ egreso.');
        }
        $tiposCorrecto = TipoVivienda::verificarConfiguracion();
        if (!$tiposCorrecto) {
            $this->addError(
                'ind_configurado',
                'La configuración de tipo de viviendas no es correcta, vuelve al paso 2'
            );
        }
        if (!$this->hasErrors()) {
            $this->ind_configurado = true;
            $this->save();

            return true;
        }

        return false;
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'inquilino_user');
    }

    public function generarTokenAcceso()
    {
        if ($this->token_acceso == "") {
            $this->token_acceso = Str::random(25);
            $this->save();
        }
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
            'nombre' => 'required|max:50',
            'host' => 'required|max:100',
            'descripcion' => 'required',
            'email_administrador' => 'required|email',
            'direccion' => '',
            'rif' => '',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Nombre',
            'host' => 'Dominio de acceso',
            'descripcion' => 'Descripción',
            'email_administrador' => 'Correo del administrador',
            'ind_configurado' => '¿Configurado?',
            'direccion' => 'Dirección',
            'modulos' => 'Módulos instalados',
            'rif' => 'RIF',
        ];
    }
}
