<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos de la cuenta (tabla users)
            'name'      => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'password'  => ['required', 'confirmed', Password::defaults()],

            // Datos del perfil de cliente (tabla clients)
            'nif'         => ['required', 'string', 'max:20', 'unique:clients,nif'],
            'tax_address' => ['required', 'string', 'max:255'],
        ];
    }

    // Nombres de los campos tal y como se mostrarán en los mensajes de error
    public function attributes(): array
    {
        return [
            'name'        => 'nombre',
            'last_name'   => 'apellidos',
            'email'       => 'correo electrónico',
            'phone'       => 'teléfono',
            'password'    => 'contraseña',
            'nif'         => 'NIF',
            'tax_address' => 'dirección fiscal',
        ];
    }

    // Mensajes en español. Los que no llevan campo delante sirven para todos.
    public function messages(): array
    {
        return [
            'required'           => 'El campo :attribute es obligatorio.',
            'max'                => 'El campo :attribute no puede superar los :max caracteres.',
            'email'              => 'Escribe un correo electrónico válido.',
            'email.unique'       => 'Ya existe una cuenta con este correo electrónico.',
            'nif.unique'         => 'Ya existe un cliente con este NIF.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos :min caracteres.',
        ];
    }

}
