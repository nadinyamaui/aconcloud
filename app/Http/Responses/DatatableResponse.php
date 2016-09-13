<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;

class DatatableResponse
{

    public $table;
    public $default_order_by = true;

    public function __construct()
    {
        $this->table = new Datatable();
    }

    public function create(Request $request, $query)
    {
        $this->table->default_order_by = $this->default_order_by;
        $this->table->prepare($request, $query);

        return response()->json($this->table);
    }
}