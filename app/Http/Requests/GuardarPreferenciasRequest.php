<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarPreferenciasRequest extends FormRequest
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
            'dia_corte_recibo'     => 'required|integer|max:28|min:1',
            'ano_inicio'           => 'required|integer',
            'mes_inicio'           => 'required|integer|max:12|min:1',
            'porcentaje_morosidad' => 'required|numeric|max:1|min:0',
            'inicio_morosidad'     => 'required|integer|min:1',
        ];
    }
}
