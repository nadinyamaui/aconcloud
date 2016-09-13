<?php namespace App\Models\Inquilino;

use App\Helpers\Helper;
use App\Models\App\User;
use App\Models\BaseModel;
use Storage;

/**
 * App\Models\Inquilino\Archivo
 *
 * @property-write mixed $ruta
 * @property-read mixed $link_descarga
 * @property-read mixed $tamano_display
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\Archivo filtrar($data)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class Archivo extends BaseModel
{

    protected $connection = "inquilino";
    protected $table = "archivos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
        'ruta',
        'item_id',
        'item_type'
    ];

    public static function asociarArchivos($ids, $item_id)
    {
        $archivos = Archivo::findMany(explode(',', $ids));
        $archivos->each(function ($archivo) use ($item_id) {
            $archivo->update(['item_id' => $item_id]);
        });
    }

    public static function columnasArchivo()
    {
        return static::getDescriptions(['nombre', 'link_descarga', 'extension', 'tamano_display']);
    }

    public function getPrettyName()
    {
        return "Archivo";
    }

    public function scopeFiltrar($query, array $data)
    {
        $query->whereItemType($data['item_type']);
        if ($data['item_id'] != "") {
            $query->whereItemId($data['item_id']);
        }

        return $query;
    }

    public function setRutaAttribute($file)
    {
        if (is_object($file)) {
            $this->attributes['ruta'] = Helper::uploadFileToStorage($file);
            $this->attributes['tamano'] = $file->getClientSize();
            $this->attributes['extension'] = $file->getClientOriginalExtension();
        }
    }

    public function getLinkDescargaAttribute()
    {
        return link_to('archivos/descargar/' . $this->id, 'Descargar');
    }

    public function getTamanoDisplayAttribute()
    {
        return Helper::formatSizeUnits($this->tamano);
    }

    protected function getRules()
    {
        return [
            'nombre' => 'required',
            'ruta' => 'required',
            'extension' => 'required',
            'tamano' => 'required',
            'permisos' => '',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'nombre' => 'Nombre del archivo',
            'ruta' => 'Ruta',
            'extension' => 'Extensión',
            'tamano' => 'Tamaño',
            'permisos' => 'Permisos',
            'tamano_display' => 'Tamaño',
            'link_descarga' => 'Descargar'
        ];
    }

    public function puedeEliminar()
    {
        return User::esJunta(true);
    }
}
