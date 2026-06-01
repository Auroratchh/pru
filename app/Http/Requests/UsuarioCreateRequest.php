<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioCreateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'nombre'                => ['required', 'string', 'max:255'],
            'apellidoPaterno'       => ['required','string',],
            'fechaNacimiento'       => ['required','date_format:d/m/Y'],
            'idSexo'                => ['required'],
            'email'                 => ['email', 'max:255',Rule::unique(User::class)->ignore($this->user()->idUsuario,'idUsuario')]
        ];

        // ,
    }
}
