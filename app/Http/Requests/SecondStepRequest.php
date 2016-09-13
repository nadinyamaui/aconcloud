<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SecondStepRequest extends Request
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
            'token_autenticacion_en_dos_pasos'=>'required|size:6'
        ];
    }
}
