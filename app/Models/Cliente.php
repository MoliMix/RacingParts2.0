<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

     protected $fillable = [
        'nombre_completo',
        'numero_id',
        'numero_telefono',
        'correo_electronico',
        'direccion_cliente',
        'sexo',
        'fecha_ingreso', // <--- ADD THIS LINE
    ];

    // Optional: Cast fecha_ingreso to a Carbon instance
    protected $casts = [
        'fecha_ingreso' => 'date',
    ];
}