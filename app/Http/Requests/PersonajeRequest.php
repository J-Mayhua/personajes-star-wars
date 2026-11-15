<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:100'],
            'altura' => ['nullable', 'integer', 'min:1', 'max:300'],
            'masa' => ['nullable', 'integer', 'min:1', 'max:500'],
            'color_cabello' => ['nullable', 'string', 'max:100'],
            'color_ojos' => ['nullable', 'string', 'max:100'],
            'genero' => ['required', 'in:masculino,femenino,n/a'],
            'planeta_origen' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'altura.integer' => 'La altura debe ser un número entero.',
            'altura.min' => 'La altura debe ser mayor o igual a 1.',
            'altura.max' => 'La altura no puede superar 300.',
            'masa.integer' => 'La masa debe ser un número entero.',
            'masa.min' => 'La masa debe ser mayor o igual a 1.',
            'masa.max' => 'La masa no puede superar 500.',
            'color_cabello.string' => 'El color de cabello debe ser texto.',
            'color_cabello.max' => 'El color de cabello no puede superar los 100 caracteres.',
            'color_ojos.string' => 'El color de ojos debe ser texto.',
            'color_ojos.max' => 'El color de ojos no puede superar los 100 caracteres.',
            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género debe ser masculino, femenino o n/a.',
            'planeta_origen.string' => 'El planeta de origen debe ser texto.',
            'planeta_origen.max' => 'El planeta de origen no puede superar los 100 caracteres.',
        ];
    }
}
