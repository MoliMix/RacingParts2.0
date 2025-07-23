<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'marca', 'modelo', 'anio', 'categoria', 'precio', 'stock'];

    /**
     * Opcional: Define la relación uno a muchos inversa con DetalleFacturaVenta.
     * Un Producto puede estar en muchos DetalleFacturaVenta.
     * No es estrictamente necesaria para tu consulta actual, pero es buena práctica.
     */
    public function detallesFacturaVenta()
    {
        return $this->hasMany(DetalleFacturaVenta::class, 'producto_id');
    }
}
