<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFacturaVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'iva',
        'subtotal',
    ];

    public function facturaVenta()
    {
        return $this->belongsTo(FacturaVenta::class, 'factura_venta_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
