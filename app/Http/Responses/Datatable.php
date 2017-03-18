<?php

namespace App\Http\Responses;

use App\Helpers\HtmlElement;
use Illuminate\Http\Request;

class Datatable
{

    public static $columnasCalculadas = ['estatus_display' => 'estatus'];
    public static $htmlTypes = ['checkbox'];
    public $recordsTotal;
    public $recordsFiltered;
    public $data;
    public $default_order_by = true;

    public function prepare(Request $request, $query)
    {
        $model = $query->getModel();
        $columns = json_decode($request->get('table_columns'));
        $columnKeys = array_keys((array)$columns);
        $this->recordsTotal = $query->count();
        //apply filters
        $search = $request->get('search');
        if ($search['value'] != "") {
            $query->where(function ($query) use ($columnKeys, $search, $model) {
                foreach ($columnKeys as $column) {
                    if (isset(static::$columnasCalculadas[$column])) {
                        $column = static::$columnasCalculadas[$column];
                    }
                    if (!in_array($column, static::$htmlTypes) && !str_contains(
                        $column,
                        '->'
                    ) && !$model->hasGetMutator($column)
                    ) {
                        $query->orWhere($column, 'LIKE', '%' . $search['value'] . '%');
                    }
                }
            });
        }
        //order by
        $orders = $request->get('order', []);
        foreach ($orders as $order) {
            $column = $columnKeys[$order['column']];
            if (isset(static::$columnasCalculadas[$column])) {
                $column = static::$columnasCalculadas[$column];
            }
            if (!in_array($column, static::$htmlTypes) && !str_contains(
                $column,
                '->'
            ) && !$query->getModel()->hasGetMutator($column)
            ) {
                $query = $query->orderBy($column, $order['dir']);
            }
        }
        if (count($orders) == 0 && $this->default_order_by) {
            $query->orderBy($model->getTable() . ".id", "DESC");
        }
        $this->recordsFiltered = $query->count();
        $elements = $query->skip($request->get('start'))->take($request->get('length'))->get();
        $this->data = [];
        foreach ($elements as $key => $element) {
            $str = "";
            foreach ($columnKeys as $column) {
                if (!in_array($column, static::$htmlTypes)) {
                    $this->data[$key][] = (string) $element->getValueAt($column, true);
                } else {
                    $obj = $columns->{$column};
                    $this->data[$key][] = (new HtmlElement($obj->type, $obj->name))->render($element->id);
                }
            }
            $url = explode('?', $request->get('url'))[0];
            if ($request->get('has_show')) {
                $str = '<a class="btn btn-primary btn-xs ' . ($request->get('modal')) . '" href="' . $url . '/' . $element->id . '" target="_blank"><i class="glyphicon glyphicon-search"></i></a>&nbsp;';
            }
            if ($request->get('has_edit')) {
                $str .= '<a class="btn btn-primary btn-xs ' . ($request->get('modal')) . '" href="' . $url . '/' . $element->id . '/edit"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;';
            }
            if ($request->get('has_delete')) {
                $str .= '<a class="btn btn-danger btn-xs boton-eliminar" href="#" data-url="' . $url . '/' . $element->id . '"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;';
            }
            $this->data[$key][] = $str;
        }

        ob_clean();
    }
}
