<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 08:13 AM
 */

namespace App\Http\Responses;


class GraficoResponse
{

    public $grafico;

    public function __construct()
    {
        $this->grafico = new Grafico();
    }

    public function create($collection, $columns)
    {
        $this->grafico->prepare($collection, $columns);

        return response()->json($this->grafico);
    }
}