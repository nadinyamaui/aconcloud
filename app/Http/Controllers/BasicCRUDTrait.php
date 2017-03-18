<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08-03-2015
 * Time: 02:09 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait BasicCRUDTrait
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        return $this->createEdit(0, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->storeUpdate($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        return $this->createEdit($id, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $this->storeUpdate($request, $id);
    }
}
