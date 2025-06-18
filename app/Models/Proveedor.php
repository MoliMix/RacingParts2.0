<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre_empresa',
        'pais_origen',
        'persona_contacto',
        'correo_electronico',
        'telefono_contacto',
        'direccion',
        'marcas',
        'tipo_autopartes',
        'persona_contacto_secundaria',
        'telefono_contacto_secundario',
    ];

    protected $casts = [
        'marcas' => 'array',
        'tipo_autopartes' => 'array',
    ];

    public static function rules(?int $id = null): array
    {
        // CAMBIO CLAVE: Se añaden los delimitadores '/' al inicio y al final de la expresión regular.
        // También se eliminó el '$' final de la regex ya que Laravel lo maneja mejor con los delimitadores.
        $phoneRegex = '/^\+\d{7,11}$/';

        return [
            'nombre_empresa' => 'required|string|max:100',
            'pais_origen' => 'required|string|max:100',
            'persona_contacto' => 'required|string|max:32|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'correo_electronico' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('proveedores', 'correo_electronico')->ignore($id),
            ],
            'telefono_contacto' => [
                'required',
                'string',
                'max:12', // Máximo 12 caracteres (incluye el +)
                'regex:' . $phoneRegex, // Ahora la variable phoneRegex incluye los delimitadores
                Rule::unique('proveedores', 'telefono_contacto')->ignore($id),
            ],
            'direccion' => 'required|string|max:255|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,#\-\/]+$/',
            'marcas' => 'required|array|min:1',
            'marcas.*' => 'string|max:50',
            'tipo_autopartes' => 'required|array|min:1',
            'tipo_autopartes.*' => 'string|max:50',
            'persona_contacto_secundaria' => 'nullable|string|max:32|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'telefono_contacto_secundario' => [
                'nullable',
                'string',
                'max:12',
                'regex:' . $phoneRegex, // Igual, la variable phoneRegex incluye los delimitadores
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'nombre_empresa.max' => 'El nombre de la empresa no debe exceder los 100 caracteres.',
            'pais_origen.required' => 'El país de origen es obligatorio.',
            'persona_contacto.required' => 'La persona de contacto es obligatoria.',
            'persona_contacto.max' => 'La persona de contacto no debe exceder los 32 caracteres.',
            'persona_contacto.regex' => 'La persona de contacto solo puede contener letras y espacios.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El formato del correo electrónico no es válido.',
            'correo_electronico.max' => 'El correo electrónico no debe exceder los 100 caracteres.',
            'correo_electronico.unique' => 'Este correo electrónico ya está registrado.',
            'telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
            'telefono_contacto.max' => 'El teléfono de contacto no debe exceder los 12 caracteres.',
            'telefono_contacto.regex' => 'El teléfono de contacto debe empezar con "+" seguido de 7 a 11 dígitos (ej. +504XXXXXXXX).',
            'telefono_contacto.unique' => 'Este teléfono de contacto ya está registrado.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no debe exceder los 255 caracteres.',
            'direccion.regex' => 'La dirección contiene caracteres no permitidos (solo letras, números, espacios, puntos, comas, guiones y #).',
            'marcas.required' => 'Debe seleccionar al menos una marca.',
            'marcas.array' => 'El campo marcas debe ser un array.',
            'marcas.min' => 'Debe seleccionar al menos una marca.',
            'tipo_autopartes.required' => 'Debe seleccionar al menos un tipo de autoparte.',
            'tipo_autopartes.array' => 'El campo tipo de autopartes debe ser un array.',
            'tipo_autopartes.min' => 'Debe seleccionar al menos un tipo de autoparte.',
            'persona_contacto_secundaria.max' => 'La persona de contacto secundaria no debe exceder los 32 caracteres.',
            'persona_contacto_secundaria.regex' => 'La persona de contacto secundaria solo puede contener letras y espacios.',
            'telefono_contacto_secundario.max' => 'El teléfono de contacto secundario no debe exceder los 12 caracteres.',
            'telefono_contacto_secundario.regex' => 'El teléfono de contacto secundario debe empezar con "+" seguido de 7 a 11 dígitos (ej. +504XXXXXXXX).',
        ];
    }
}