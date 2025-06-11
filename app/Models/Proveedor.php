<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre_empresa',
        'pais_origen',
        'direccion',
        'persona_contacto',
        'correo_electronico',
        'telefono_contacto',
        'marcas',
        'tipo_autopartes',
        'persona_contacto_secundaria',
        'telefono_contacto_secundario'
    ];

    protected $casts = [
        'marcas' => 'array',
        'tipo_autopartes' => 'array'
    ];

    public static function rules($id = null)
    {
        return [
            'nombre_empresa' => 'required|string|max:255',
            'pais_origen' => 'required|string|max:100',
            'persona_contacto' => 'required|string|max:255',
            'correo_electronico' => 'required|email|max:255',
            'telefono_contacto' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'marcas' => 'required|array|min:1',
            'tipo_autopartes' => 'required|array|min:1',
            'persona_contacto_secundaria' => 'nullable|string|max:255',
            'telefono_contacto_secundario' => 'nullable|string|max:20'
        ];
    }

    public static function messages()
    {
        return [
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'pais_origen.required' => 'El país de origen es obligatorio.',
            'persona_contacto.required' => 'La persona de contacto es obligatoria.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El correo electrónico debe ser válido.',
            'telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'marcas.required' => 'Debe seleccionar al menos una marca.',
            'tipo_autopartes.required' => 'Debe seleccionar al menos un tipo de autoparte.'
        ];
    }
} 