<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'sobrenome'      => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users,email',
            'password'       => 'required|string|min:8|confirmed',
            'trainer_name'   => 'required|string|max:255', // novo campo
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'O nome é obrigatório.',
            'sobrenome.required'      => 'O sobrenome é obrigatório.',
            'email.required'          => 'O email é obrigatório.',
            'email.unique'            => 'Este email já está cadastrado.',
            'password.required'       => 'A senha é obrigatória.',
            'password.confirmed'      => 'As senhas não coincidem.',
            'trainer_name.required' => 'O nome de treinador é obrigatório.',
        ];
    }
}
