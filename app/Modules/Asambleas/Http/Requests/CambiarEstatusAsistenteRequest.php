<?php

namespace App\Modules\Asambleas\Http\Requests;

use App\Http\Requests\Request;

class CambiarEstatusAsistenteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'asistente_id'=>'required|integer|min:1',
            'estatus'=>'required|integer|min:0|max:1',
        ];
    }
}
