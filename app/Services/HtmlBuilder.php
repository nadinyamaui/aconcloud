<?php

namespace App\Services;

use App\Models\App\Inquilino;
use Collective\Html\HtmlBuilder as BaseHtmlBuilder;

class HtmlBuilder extends BaseHtmlBuilder
{

    function activarInquilino()
    {
        $this->url->forceRootUrl("http://" . Inquilino::$current->host);
    }

    function customTable($collection, $modelName, $campos, $table_id = "")
    {
        $model = new $modelName();
        $array = [];
        foreach ($campos as $display) {
            $array[$display] = $model->getDescription($display);
        }
        $data['prettyFields'] = $array;
        $data['collection'] = $collection;
        $data['botones'] = [];
        $data['table_id'] = $table_id;

        return \View::make('templates.bootstrap.simpleTable', $data)->render();
    }

    function tableAjax(
        $modelName,
        array $columns,
        $hasAdd = true,
        $hasEdit = true,
        $hasDelete = true,
        $hasShow = false,
        $url = "",
        $modal = false
    ) {
        $model = new $modelName();
        $data['prettyFields'] = $columns;
        if ($url == "" || count($url) == 0) {
            $ruta = \Route::getCurrentRoute();
            $data['url'] = url($ruta->getPath());
        } else {
            if (is_string($url)) {
                $data['url'] = url($url);
            } else {
                if (is_array($url)) {
                    $data['url'] = url($url['list']);
                    $data['urlCrud'] = url($url['url']);
                }
            }
        }
        if (!isset($data['urlCrud'])) {
            $data['urlCrud'] = $data['url'];
        }
        $data['hasAdd'] = $hasAdd;
        if ($hasAdd) {
            if (str_contains($data['url'], '?')) {
                $temp = explode('?', $data['url']);
                $data['urlAdd'] = $temp[0] . '/create?' . $temp[1];
            } else {
                $data['urlAdd'] = $data['url'] . '/create';
            }
            $data['nombreAdd'] = $model->getPrettyName();
        }
        $data['modal'] = '';
        if ($modal) {
            $data['modal'] = 'abrir-modal';
        }

        if (str_contains($data['url'], '?')) {
            $params = explode('?', $data['url']);
            $data['urlAjax'] = $params[0] . '/datatable?';
            unset($params[0]);
            $data['urlAjax'] .= implode('&', $params);
        } else {
            $data['urlAjax'] = $data['url'] . '/datatable';
        }
        $data['hasShow'] = $hasShow;
        $data['hasEdit'] = $hasEdit;
        $data['hasDelete'] = $hasDelete;

        return \View::make('templates.bootstrap.tableAjax', $data)->render();
    }

    function imageLink($hrefLink, $toltip, $urlImage)
    {
        return "<a href='" . url($hrefLink) . "'>"
        . "<img src='" . url($urlImage) . "' title='$toltip'></a>";
    }

    function btnAgregar($url, $nombre)
    {
        $data['url'] = $url;
        $data['nombre'] = $nombre;

        return View::make('templates.bootstrap.btnagregar', $data);
    }
}
