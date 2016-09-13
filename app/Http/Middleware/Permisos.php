<?php namespace App\Http\Middleware;

class Permisos
{

    public function denyAccess()
    {
        if (\Request::ajax()) {
            return \Response::make('Forbidden', 403);
        } else {
            return \Response::view('errors.403', [], 403);
        }
    }

}
