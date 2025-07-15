<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    use HasFactory;

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = ['fecha', 'cliente', 'subtotal', 'iva', 'total'];

    // Define el casting de atributos para que 'fecha' sea un objeto de fecha (Carbon)
    // Esto es crucial para poder usar métodos como ->format() en la vista.
    protected $casts = [
        'fecha' => 'datetime',
        // Si 'created_at' y 'updated_at' también te dan problemas y los renombraste,
        // asegúrate de que tus migraciones los hayan renombrado a los nombres por defecto de Laravel
        // o define sus casts aquí también si usas nombres personalizados y no las constantes.
        // Por ejemplo: 'creado_en' => 'datetime', 'actualizado_a las' => 'datetime',
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
