<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of BaseModel
 * Modelo base que extiende a eloquent con todo lo necesario para validaciones.
 * y observadores
 *
 * Validaciones: Para poder usar la validacion se debe incluir el atributo $rules para el validator.
 * Si se quiere validación especial se debe sobreescribir el metodo Validate.
 * Por defecto el metodo validate es ejecutado con el evento save();
 *
 * @method static static find($id)
 * @method static static findMany($id)
 * @method static static findOrFail($id)
 * @method static static firstOrNew(array $array)
 *
 * @author Nadin Yamaui
 */
abstract class BaseModel extends Model
{

    public static $cmbsexo = [
        ''  => 'Seleccione',
        'M' => 'Masculino',
        'F' => 'Femenino'
    ];
    public static $decimalPositions = 2;
    protected static $cmbsino = [
        '0' => 'No',
        '1' => 'Si'
    ];
    protected static $estatusArray = [
        'PEN' => 'Pendiente',
        'PRO' => 'Procesado',
        'GEN' => 'Generado',
        'VEN' => 'Vencido',
        'PAG' => 'Pagado',
        'ELA' => 'Elaboración',
        'ACT' => 'Activo',
    ];
    protected static $decimalFields = [];
    /**
     * Error message bag
     * @var Illuminate\Support\MessageBag
     */
    public $errors;
    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save,
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran
     * persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $appends = [];
    protected $dates = [];
    protected $displayTable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->errors = new MessageBag();
    }

    public static function create(array $attributes = [])
    {
        $model = new static();
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    public function fill(array $atributos)
    {
        foreach ($atributos as $key => $atributo) {
            if ($atributo == "" && !$this->isBooleanField($key)) {
                $atributos[$key] = null;
            } else {
                if ($atributo == "" || is_null($atributo)) {
                    $atributos[$key] = false;
                } else {
                    if ($atributo != "" && $this->isDecimalField($key)) {
                        $atributos[$key] = Helper::tf($atributo);
                    } else {
                        if ($atributo != "" && $this->isDateField($key)) {
                            try {
                                $atributos[$key] = Carbon::createFromFormat('d/m/Y', $atributo);
                            } catch (\InvalidArgumentException $e) {
                                $atributos[$key] = Carbon::createFromFormat('Y-m-d H:i:s', $atributo);
                            }
                        }
                    }
                }
            }
        }

        return parent::fill($atributos);
    }

    public function isBooleanField($field)
    {
        return starts_with($field, 'ind_');
    }

    public function isDecimalField($field)
    {
        return in_array($field, static::$decimalFields);
    }

    public function isDateField($field)
    {
        return in_array($field, $this->dates);
    }

    public static function findOrNew($str, $columns = [])
    {
        if ($str == "") {
            return new static();
        } else {
            return static::findOrFail($str);
        }
    }

    public static function getCombo($campo = "Seleccione")
    {
        $campoCombo = static::getCampoCombo();
        $campoOrder = static::getCampoOrder() != "" ? static::getCampoOrder() : $campoCombo;

        if (static::getWhereCondition() != null) {
            $registros = static::getWhereCondition()->orderBy($campoOrder);
        } else {
            $registros = static::orderBy($campoOrder);
        }
        $retorno = ['' => $campo];
        foreach ($registros->get() as $registro) {
            $retorno[$registro->id] = $registro->{$campoCombo};
        }
        if ($campo == "" && count($retorno) > 1) {
            unset($retorno['']);
        }

        return $retorno;
    }

    public static function getCampoCombo()
    {
        return "nombre";
    }

    public static function getCampoOrder()
    {
        return "";
    }

    public static function getWhereCondition()
    {
        return null;
    }

    public static function getDescriptions(array $array)
    {
        $obj = new static();
        $arrReturn = [];
        foreach ($array as $key => $display) {
            $arrReturn[is_string($display) ? $display : $key] = $obj->getDescription($display);
        }

        return $arrReturn;
    }

    public function getDescription($attr)
    {
        if (!is_string($attr)) {
            return $attr;
        }
        $arr = explode('->', $attr);
        $labels = $this->getPrettyFields();
        switch (count($arr)) {
            case 3:
                $instance = $this->{$arr[0]}()->getRelated();
                $labels = $instance->getPrettyFields();
                $key = snake_case($arr[1]) . '_id';
                break;
            case 2:
                $key = snake_case($arr[0]) . '_id';
                break;
            case 1:
                $key = $attr;
                break;
        }
        if (isset($labels[$key])) {
            return $labels[$key];
        }

        return $key;
    }

    /**
     * Validates current attributes against rules
     */
    public function validate()
    {
        $validator = app('validator');

        // Override the database connection
        if ($this->connection) {
            $validator->getPresenceVerifier()->setConnection($this->connection);
        }
        $v = $validator->make($this->attributes, $this->getRules());
        $v->setAttributeNames($this->getPrettyFields());
        if ($v->passes()) {
            $this->afterValidate();

            return true;
        }
        $this->appendErrors($v->messages());

        return false;
    }

    protected abstract function getRules();

    protected abstract function getPrettyFields();

    protected function afterValidate()
    {

    }

    protected function appendErrors($messages)
    {
        $this->getErrors()->merge($messages);
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function hasErrors()
    {
        return $this->errors->count() > 0;
    }

    public function getValueAt($key, $format = true)
    {
        $arr = explode('->', $key);
        switch (count($arr)) {
            case 3:
                if (isset($this->{$arr[0]}->{$arr[1]}->{$arr[2]})) {
                    return $this->{$arr[0]}->{$arr[1]}->{$arr[2]};
                }
                break;
            case 2:
                if (isset($this->{$arr[0]}->{$arr[1]})) {
                    return $this->{$arr[0]}->{$arr[1]};
                }
            case 1:
                if ($format && $this->isBooleanField($key) &&
                    isset(static::$cmbsino[$this->{$key}])
                ) {
                    return static::$cmbsino[$this->{$key}];
                }
                if ($format && $this->isDateField($key) && is_object($this->{$key})) {
                    return $this->{$key}->format('d/m/Y');
                }
                if ($format && $this->isDecimalField($key)) {
                    return Helper::tm($this->{$key}, static::$decimalPositions);
                }

                return $this->{$key};
        }

        return "";
    }

    public function addError($var, $description)
    {
        if (is_array($var)) {
            foreach ($var as $elem) {
                $this->errors->add($elem, $description);
            }
        } else {
            $this->errors->add($var, $description);
        }
    }

    public function isRelatedField($field)
    {
        $test = $this->getRelatedField($field);
        //Yes the field is a relationn
        if (class_basename($test) == "BelongsTo") {
            return true;
        } else {
            return false;
        }
    }

    private function getRelatedField($field, $getInstance = false)
    {
        $arr = explode('->', $field);
        switch (count($arr)) {
            case 3:
                $field = str_replace('_id', '', $arr[2]);
                $camelField = camel_case($field);
                $parent = $this->{$arr[0]}()->getRelated()->{$arr[1]}()->getRelated();
                if (method_exists($parent, $camelField)) {
                    //Return..
                    if ($getInstance && isset($this->{$arr[0]}->{$arr[1]}->{$camelField})) {
                        return $this->{$arr[0]}->{$arr[1]}->{$camelField};
                    } else {
                        if (!$getInstance) {
                            return $parent->{$camelField}();
                        }
                    }
                }
            case 2:
                $field = str_replace('_id', '', $arr[1]);
                $camelField = camel_case($field);
                $parent = $this->{$arr[0]}()->getRelated();
                //Method Existss??
                if (method_exists($parent, $camelField)) {
                    //Return..
                    if ($getInstance && isset($this->{$arr[0]}->{$camelField})) {
                        return $this->{$arr[0]}->{$camelField};
                    } else {
                        if (!$getInstance) {
                            return $parent->{$camelField}();
                        }
                    }
                }
            case 1:
                $field = str_replace('_id', '', $field);
                $camelField = camel_case($field);
                //Method Existss??
                if (method_exists($this, $camelField)) {
                    //Return..
                    if ($getInstance && isset($this->{$camelField})) {
                        return $this->{$camelField};
                    } else {
                        if (!$getInstance) {
                            return $this->{$camelField}();
                        }
                    }
                }
        }

        return null;
    }

    public function getRelatedOptions($field)
    {
        $related = $this->getRelatedField($field, false)->getRelated();
        $className = get_class($related);
        if (method_exists($related, 'getParent')) {
            $relatedObj = $this->getRelatedField($field, true);
            if (is_object($relatedObj)) {
                return call_user_func([$className, 'getCombo'], $relatedObj->{$related->getParent()});
            } else {
                return call_user_func([$className, 'getCombo']);
            }
        } else {
            return call_user_func([$className, 'getCombo']);
        }
    }

    public function isRequired($field)
    {
        $rules = $this->rules;
        if (isset($rules[$field])) {
            return strpos($rules[$field], 'required') !== false && strpos($rules[$field], 'required_') === false;
        }

        return false;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function getEstatusDisplayAttribute()
    {
        return static::$estatusArray[$this->estatus];
    }

    public function clearErrors()
    {
        $this->errors = new MessageBag();
    }

    public function scopeWhereMonth($query, $field, $value)
    {
        return $query->whereRaw('MONTH(' . $field . ') = ?', [$value]);
    }

    public function scopeWhereYear($query, $field, $value)
    {
        return $query->whereRaw('YEAR(' . $field . ') = ?', [$value]);
    }

    public function scopeWhereMonthYear($query, $field, $month, $year)
    {
        return $query->whereRaw('MONTH(' . $field . ') = ? AND YEAR(' . $field . ') = ?', [$month, $year]);
    }

    public function getDecimalPositions()
    {
        return static::$decimalPositions;
    }

    public function validateImage(UploadedFile $file)
    {
        $rule = [
            'image' => 'image|max:2048',
        ];
        $data = [
            'image' => $file,
        ];
        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            $this->appendErrors($validator->messages());

            return false;
        }

        return true;
    }

    public abstract function getPrettyName();
}
