<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Este método añade la columna 'iva' a la tabla 'detalle_factura_ventas'.
     */
    public function up(): void
    {
        Schema::table('detalle_factura_ventas', function (Blueprint $table) {
            // Añade la columna 'iva' como decimal con 10 dígitos en total y 2 decimales.
            // Se coloca después de 'precio_unitario' y se le asigna un valor predeterminado de 0.00
            // para evitar problemas con registros existentes si los hubiera.
            if (!Schema::hasColumn('detalle_factura_ventas', 'iva')) {
                $table->decimal('iva', 10, 2)->after('precio_unitario')->default(0.00);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * Este método revierte la migración, eliminando la columna 'iva' de la tabla.
     */
    public function down(): void
    {
        Schema::table('detalle_factura_ventas', function (Blueprint $table) {
            // Elimina la columna 'iva' si existe al revertir la migración.
            if (Schema::hasColumn('detalle_factura_ventas', 'iva')) {
                $table->dropColumn('iva');
            }
        });
    }
};
