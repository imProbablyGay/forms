<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => 'required | max:50 | unique:users',
            "email" => 'required | email | max:100 | unique:users',
            "password" => 'required | confirmed | max:50',
        ];
    }

    public function messages()
    {
        return [
            "name.unique" => 'Такое имя уже зарегестрировано',
            "email.unique" => 'Такой email уже зарегестрирован',
            "password.confirmed" => 'Пароли не совпадают'
        ];
    }
}
