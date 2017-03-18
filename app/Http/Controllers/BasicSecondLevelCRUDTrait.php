<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait BasicSecondLevelCRUDTrait
{

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($element_id, Request $request)
    {
        return $this->createEdit($element_id, 0, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($element_id, Request $request)
    {
        return $this->storeUpdate($element_id, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($element_id, Request $request, $id)
    {
        return $this->createEdit($element_id, $id, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($element_id, Request $request, $id)
    {
        return $this->storeUpdate($element_id, $request, $id);
    }
}
