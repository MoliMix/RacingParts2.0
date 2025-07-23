<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'fecha', 'cliente', 'subtotal', 'iva', 'total'];


    protected $casts = [
        'fecha' => 'datetime',


    ];

    /**
     * Define la relación uno a muchos con DetalleFacturaVenta.
     * Una FacturaVenta puede tener muchos DetalleFacturaVenta.
     * 'factura_venta_id' es la clave foránea en la tabla 'detalle_factura_ventas'.
     */
    public function detalles()
    {
        return $this->hasMany(DetalleFacturaVenta::class, 'factura_venta_id');
    }
}
