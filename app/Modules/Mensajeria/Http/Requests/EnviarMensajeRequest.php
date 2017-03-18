<?php

namespace App\Modules\Mensajeria\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class EnviarMensajeRequest extends FormRequest
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
            'asunto'     => 'required',
            'cuerpo'     => 'required_if:ind_sms,0',
            'cuerpo_sms' => 'required_if:ind_sms,1',
        ];
    }
}
