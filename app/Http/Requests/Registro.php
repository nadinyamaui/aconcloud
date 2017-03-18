<?php namespace App\Http\Requests;

class Registro extends Request
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
            'nombre'                => 'required',
            'apellido'              => 'required',
            'email'                 => 'required',
            'password'              => 'required',
            'password_confirmation' => 'required',
            'tipo_vivienda_id'      => 'required',
            'numero_apartamento'    => 'required',
            'piso'                  => 'required',
            'torre'                 => '',
        ];
    }
}
