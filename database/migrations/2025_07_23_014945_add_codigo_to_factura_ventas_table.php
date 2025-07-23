<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str; // Importar la clase Str para generar cadenas aleatorias
use Illuminate\Support\Facades\DB; // Importar la clase DB para interactuar con la base de datos

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Añade la columna 'codigo' como nullable primero, solo si no existe.
        if (!Schema::hasColumn('factura_ventas', 'codigo')) {
            Schema::table('factura_ventas', function (Blueprint $table) {
                $table->string('codigo')->nullable()->after('id');
            });
        }

        // 2. Generar códigos únicos para las facturas existentes que tienen 'codigo' nulo o vacío.
        // Esto se hace para asegurar que todos los registros tengan un código antes de hacerlo NOT NULL UNIQUE.
        $facturasToUpdate = DB::table('factura_ventas')
            ->whereNull('codigo')
            ->orWhere('codigo', '')
            ->get();

        foreach ($facturasToUpdate as $factura) {
            $uniqueCode = 'FAC-' . date('YmdHis') . Str::random(6);
            // Asegurarse de que el código generado sea realmente único antes de asignarlo.
            while (DB::table('factura_ventas')->where('codigo', $uniqueCode)->exists()) {
                $uniqueCode = 'FAC-' . date('YmdHis') . Str::random(6);
            }
            DB::table('factura_ventas')->where('id', $factura->id)->update(['codigo' => $uniqueCode]);
        }

        // 3. Una vez que todos los códigos están llenos, haz la columna única y no nula.
        // El método 'change()' requiere la instalación del paquete 'doctrine/dbal'
        // (composer require doctrine/dbal --with-all-dependencies).
        Schema::table('factura_ventas', function (Blueprint $table) {
            $table->string('codigo')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factura_ventas', function (Blueprint $table) {
            // Cuando se revierta la migración, elimina la columna 'codigo'.
            $table->dropColumn('codigo');
        });
    }
};


