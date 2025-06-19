<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule; // <-- ¡IMPORTANTE! Asegúrate de que esta línea esté presente

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // Asegúrate de que este sea el nombre EXACTO de tu tabla en la base de datos

    protected $fillable = [
        'nombre_empresa',
        'pais_origen',
        'persona_contacto',
        'telefono_contacto',
        'correo_electronico',
        'direccion',
        'marcas',
        'tipo_autopartes',
        'persona_contacto_secundaria',
        'telefono_contacto_secundario',
    ];

    // Casta los campos array a JSON para manejo automático por Laravel
    protected $casts = [
        'marcas' => 'array',
        'tipo_autopartes' => 'array',
    ];

    /**
     * Define las reglas de validación para el modelo Proveedor.
     *
     * @param int|null $id El ID del proveedor para ignorar en reglas únicas (en caso de actualización).
     * @return array
     */
    public static function rules(?int $id = null): array
    {
        return [
            'nombre_empresa' => [
                'required',
                'string',
                'max:30',
                // <-- ¡ESTA ES LA REGLA CLAVE PARA LA UNICIDAD!
                Rule::unique('proveedores')->ignore($id, 'nombre_empresa'),
            ],
            'pais_origen' => ['required', 'string', 'max:50'],
            'persona_contacto' => ['required', 'string', 'max:32', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'telefono_contacto' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'regex:/^\+\d{7,11}$/',
                Rule::unique('proveedores')->ignore($id, 'telefono_contacto'),
            ],
            'correo_electronico' => [
                'required',
                'email',
                'max:30',
                Rule::unique('proveedores')->ignore($id, 'correo_electronico'),
            ],
            'direccion' => ['required', 'string', 'max:150'],
            'marcas' => ['required', 'array', 'min:1'],
            'marcas.*' => ['string'],
            'tipo_autopartes' => ['required', 'array', 'min:1'],
            'tipo_autopartes.*' => ['string'],
            'persona_contacto_secundaria' => ['nullable', 'string', 'max:32', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/u'],
            'telefono_contacto_secundario' => ['nullable', 'string', 'min:8', 'max:12', 'regex:/^\+\d{7,11}$/'],
        ];
    }

    /**
     * Define los mensajes personalizados para las reglas de validación.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'nombre_empresa.max' => 'El nombre de la empresa no debe tener más de 30 caracteres.',
            'nombre_empresa.unique' => 'Este nombre de empresa ya está registrado.', // <-- ¡ESTE ES EL MENSAJE ESPECÍFICO!

            'pais_origen.required' => 'El país de origen es obligatorio.',

            'persona_contacto.required' => 'La persona de contacto es obligatoria.',
            'persona_contacto.max' => 'La persona de contacto no debe tener más de 32 caracteres.',
            'persona_contacto.regex' => 'La persona de contacto solo puede contener letras y espacios.',

            'telefono_contacto.required' => 'El teléfono de contacto principal es obligatorio.',
            'telefono_contacto.min' => 'El teléfono de contacto debe tener al menos 8 caracteres (incluyendo el +).',
            'telefono_contacto.max' => 'El teléfono de contacto no debe exceder los 12 caracteres (incluyendo el +).',
            'telefono_contacto.regex' => 'El formato del teléfono principal es inválido; debe empezar con + y tener entre 7 y 11 dígitos.',
            'telefono_contacto.unique' => 'Este teléfono ya está registrado para otro proveedor.',

            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'Ingrese un correo electrónico válido.',
            'correo_electronico.max' => 'El correo electrónico no debe tener más de 30 caracteres.',
            'correo_electronico.unique' => 'Este correo electrónico ya está registrado para otro proveedor.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no debe tener más de 150 caracteres.',

            'marcas.required' => 'Debe seleccionar al menos una marca.',
            'marcas.array' => 'El campo marcas debe ser un array.',
            'marcas.min' => 'Debe seleccionar al menos una marca.',

            'tipo_autopartes.required' => 'Debe seleccionar al menos un tipo de autopartes.',
            'tipo_autopartes.array' => 'El campo tipo de autopartes debe ser un array.',
            'tipo_autopartes.min' => 'Debe seleccionar al menos un tipo de autoparte.',

            'persona_contacto_secundaria.max' => 'La persona de contacto secundaria no debe tener más de 32 caracteres.',
            'persona_contacto_secundaria.regex' => 'La persona de contacto secundaria solo puede contener letras y espacios.',

            'telefono_contacto_secundario.min' => 'El teléfono de contacto secundario debe tener al menos 8 caracteres (incluyendo el +).',
            'telefono_contacto_secundario.max' => 'El teléfono de contacto secundario no debe exceder los 12 caracteres (incluyendo el +).',
            'telefono_contacto_secundario.regex' => 'El formato del teléfono secundario es inválido; debe empezar con + y tener entre 7 y 11 dígitos.',
        ];
    }
}
