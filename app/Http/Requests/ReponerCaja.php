<?php namespace App\Http\Requests;

class ReponerCaja extends Request
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
            'referencia'    => 'required',
            'cuenta_id'     => 'required',
            'monto_reponer' => 'required',
        ];
    }

}
