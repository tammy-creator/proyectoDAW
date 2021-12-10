<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|min:3|max:5',
            'apellidos'=>'required|min:3|max:50',
            'direccion'=>'required|max:50',
            'telefono'=>'required|integer',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
    }
}
