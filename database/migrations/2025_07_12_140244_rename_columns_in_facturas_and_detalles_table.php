<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Renombrar columnas en la tabla 'factura_ventas'
        Schema::table('factura_ventas', function (Blueprint $table) {
            // Renombrar la clave primaria 'identificación' a 'id'
            // NOTA: Si ya tienes una columna 'id' y 'identificación' es un campo diferente,
            // o si 'id' ya es la PK, ajusta esto. Asumimos que 'identificación' es tu PK.
            if (Schema::hasColumn('factura_ventas', 'identificación')) {
                $table->renameColumn('identificación', 'id');
            }

            // Renombrar la columna 'total parcial' a 'total'
            // Asumimos que 'total parcial' es el campo que quieres que sea el 'total' final.
            if (Schema::hasColumn('factura_ventas', 'total parcial')) {
                $table->renameColumn('total parcial', 'total');
            }

            // Renombrar los timestamps
            if (Schema::hasColumn('factura_ventas', 'creado_en')) {
                $table->renameColumn('creado_en', 'created_at');
            }
            if (Schema::hasColumn('factura_ventas', 'actualizado_a las')) {
                $table->renameColumn('actualizado_a las', 'updated_at');
            }
        });

        // Renombrar columnas en la tabla 'detalle_factura_ventas'
        Schema::table('detalle_factura_ventas', function (Blueprint $table) {
            // Renombrar la clave primaria 'identificación' a 'id'
            // NOTA: Igual que arriba, ajusta si tu PK ya es 'id' o si 'identificación' es otro campo.
            if (Schema::hasColumn('detalle_factura_ventas', 'identificación')) {
                $table->renameColumn('identificación', 'id');
            }

            // Renombrar la clave foránea de producto
            if (Schema::hasColumn('detalle_factura_ventas', 'id del producto')) {
                $table->renameColumn('id del producto', 'producto_id');
            }

            // Renombrar la columna 'total parcial' a 'subtotal'
            if (Schema::hasColumn('detalle_factura_ventas', 'total parcial')) {
                $table->renameColumn('total parcial', 'subtotal');
            }

            // Renombrar los timestamps
            if (Schema::hasColumn('detalle_factura_ventas', 'creado_en')) {
                $table->renameColumn('creado_en', 'created_at');
            }
            if (Schema::hasColumn('detalle_factura_ventas', 'actualizado_a las')) {
                $table->renameColumn('actualizado_a las', 'updated_at');
            }
        });
    }

    /**
     * Revierte las migraciones.
     *
     * Este método revierte los cambios realizados en el método 'up()',
     * renombrando las columnas de vuelta a sus nombres originales.
     */
    public function down(): void
    {
        // Revertir renombrado de columnas en la tabla 'factura_ventas'
        Schema::table('factura_ventas', function (Blueprint $table) {
            if (Schema::hasColumn('factura_ventas', 'id')) {
                $table->renameColumn('id', 'identificación');
            }
            if (Schema::hasColumn('factura_ventas', 'total')) {
                $table->renameColumn('total', 'total parcial');
            }
            if (Schema::hasColumn('factura_ventas', 'created_at')) {
                $table->renameColumn('created_at', 'creado_en');
            }
            if (Schema::hasColumn('factura_ventas', 'updated_at')) {
                $table->renameColumn('updated_at', 'actualizado_a las');
            }
        });

        // Revertir renombrado de columnas en la tabla 'detalle_factura_ventas'
        Schema::table('detalle_factura_ventas', function (Blueprint $table) {
            if (Schema::hasColumn('detalle_factura_ventas', 'id')) {
                $table->renameColumn('id', 'identificación');
            }
            if (Schema::hasColumn('detalle_factura_ventas', 'producto_id')) {
                $table->renameColumn('producto_id', 'id del producto');
            }
            if (Schema::hasColumn('detalle_factura_ventas', 'subtotal')) {
                $table->renameColumn('subtotal', 'total parcial');
            }
            if (Schema::hasColumn('detalle_factura_ventas', 'created_at')) {
                $table->renameColumn('created_at', 'creado_en');
            }
            if (Schema::hasColumn('detalle_factura_ventas', 'updated_at')) {
                $table->renameColumn('actualizado_a las', 'actualizado_a las');
            }
        });
    }
};
