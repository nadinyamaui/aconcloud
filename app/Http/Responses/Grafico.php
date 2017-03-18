<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30-03-2015
 * Time: 04:57 PM
 */

namespace App\Http\Responses;

class Grafico
{

    public $data;

    public function prepare($collection, $columns)
    {
        foreach ($collection as $element) {
            $this->data[] = new ElementoGrafico($element->{$columns[0]}, $element->{$columns[1]});
        }
    }
}
