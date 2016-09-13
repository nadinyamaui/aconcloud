<?php namespace App\Models\Inquilino;

use App\Models\App\Grupo;
use App\Models\App\Inquilino;
use App\Models\App\SmsEnviado;
use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Inquilino\ClasificacionIngresoEgreso
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $dia_estimado
 * @property boolean $ind_fijo
 * @property float $monto
 * @property boolean $ind_egreso
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereDiaEstimado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereIndFijo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereMonto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereIndEgreso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereUpdatedAt($value)
 * @method static \App\Models\BaseModel whereMonth($field, $value)
 * @method static \App\Models\BaseModel whereYear($field, $value)
 * @method static \App\Models\BaseModel whereMonthYear($field, $month, $year)
 * @property boolean $ind_bloqueado
 * @property string $codigo
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereIndBloqueado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\ClasificacionIngresoEgreso
 *     whereCodigo($value)
 */
class ClasificacionIngresoEgreso extends BaseModel
{

    public static $decimalFields = ['monto'];
    protected $connection = "inquilino";
    protected $table = "clasificacion_ingreso_egreso";
    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'dia_estimado',
        'ind_fijo',
        'monto',
        'ind_egreso',
        'ind_bloqueado',
        'codigo'
    ];

    public static function getLista($gasto)
    {
        $retorno[''] = "Seleccione";
        $elems = self::whereIndEgreso($gasto)->whereNull("codigo")->select(['id', 'nombre'])->get();
        foreach ($elems as $elem) {
            $retorno[$elem->id] = $elem->nombre;
        }

        return $retorno;
    }

    public static function reposicionCajaChica()
    {
        return self::whereCodigo("cajachica")->first();
    }

    public static function cuotaAconcloud()
    {
        return self::whereCodigo("aconcloud")->first();
    }

    public static function pagoRecibos()
    {
        return self::whereCodigo("pago.recibos")->first();
    }

    public static function generarMovimientosAutomaticos()
    {
        $hoy = Carbon::now();
        $clasificaciones = self::whereIndFijo(true)->whereDiaEstimado($hoy->day)->get();
        $clasificaciones->each(function (ClasificacionIngresoEgreso $clasificacion) {
            $cuenta = Cuenta::first();
            $movimiento = new MovimientosCuenta();
            $movimiento->cuenta()->associate($cuenta);
            $movimiento->clasificacion()->associate($clasificacion);
            $movimiento->numero_factura = "N/A";
            if ($clasificacion->ind_egreso) {
                $movimiento->tipo_movimiento = "ND";
                $movimiento->monto_egreso = $clasificacion->monto;
            } else {
                $movimiento->tipo_movimiento = "NC";
                $movimiento->monto_ingreso = $clasificacion->monto;
            }
            $movimiento->fecha_factura = Carbon::now();
            $movimiento->forma_pago = "banco";
            $movimiento->referencia = Str::random();
            $movimiento->save();

            $clasificacion->generarAlarma($movimiento);
        });
    }

    private function generarAlarma($movimiento)
    {
        $alarma = new Alarma();
        $alarma->fecha_vencimiento = Carbon::now();
        $alarma->fecha_advertencia = Carbon::now();
        $alarma->nombre = $this->nombre;
        $alarma->item()->associate($movimiento);
        if ($this->ind_egreso) {
            $alarma->link_handle = "registrar/gastos/" . $movimiento->id . "/edit";
            $alarma->descripcion = "Registrar pago de " . $this->nombre;
        } else {
            $alarma->link_handle = "registrar/ingresos/" . $movimiento->id . "/edit";
            $alarma->descripcion = "Registrar ingreso de " . $this->nombre;
        }
        $grupos = Grupo::whereIn('codigo', ['junta', 'admin'])->get()->lists('id')->all();
        $usuarios = Inquilino::$current->inquilinoUsuarios()->whereIn('grupo_id', $grupos)->get();
        $alarma->save();
        $alarma->users()->sync($usuarios->lists('user_id')->all());
        $alarma->notificar();

        if ($this->ind_egreso) {
            $mensaje = "Aconcloud te informa que tu condominio presenta una deuda vencida por el concepto de " . $this->nombre;
        } else {
            $mensaje = "Aconcloud te informa que tu condominio presenta un ingreso pendiente por el concepto de " . $this->nombre;
        }
        foreach ($usuarios as $usuario) {
            SmsEnviado::encolar($mensaje, $usuario->user);
        }
    }

    public function getPrettyName()
    {
        return "Clasificacion ingreso/ egreso";
    }

    public function puedeEditar()
    {
        return $this->ind_bloqueado == 0;
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
            'dia_estimado' => 'integer|max:31|min:1',
            'ind_fijo' => 'required',
            'monto' => '',
            'ind_egreso' => 'required',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Nombre',
            'dia_estimado' => 'Dia de corte',
            'ind_fijo' => '¿Fijo?',
            'monto' => 'Monto estimado',
            'ind_egreso' => "¿Es un egreso?",
        ];
    }
}
