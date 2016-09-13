<?php namespace App\Models\Inquilino;

use App\Models\App\User;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Inquilino\MensajeChat
 *
 * @property-read User $autor
 * @property-read mixed $es_autor
 * @property-read mixed $tiempo_display
 * @property-read mixed $nombre_completo
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquilino\MensajeChat filtrar($data)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonth($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereYear($field, $value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel whereMonthYear($field, $month, $year)
 */
class MensajeChat extends BaseModel
{

    protected $connection = "inquilino";
    protected $table = "mensajes_chat";
    protected $appends = ['es_autor', 'tiempo_display', 'nombre_completo'];

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'autor_id',
        'message',
        'item_type',
        'item_id'
    ];

    public function getPrettyName()
    {
        return "Mensajes del chat";
    }

    public function scopeFiltrar($query, array $data)
    {
        $query->whereItemType($data['item_type']);
        if ($data['item_id'] != "") {
            $query->whereItemId($data['item_id']);
        }

        return $query;
    }

    public function autor()
    {
        return $this->belongsTo(User::class);
    }

    public function getEsAutorAttribute()
    {
        return $this->autor_id == Auth::id();
    }

    public function getTiempoDisplayAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getNombreCompletoAttribute()
    {
        return $this->autor->nombre_completo;
    }

    public function getDefaultValues()
    {
        return [
            'autor_id' => Auth::id(),
        ];
    }

    protected function getRules()
    {
        return [
            'autor_id' => 'required',
            'message' => 'required',
            'item_type' => 'required',
            'item_id' => 'required'
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
}
