<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Añade la columna 'precio' como decimal con 10 dígitos en total y 2 decimales
            // Después de la columna 'categoria' para mantener un orden lógico
            $table->decimal('precio', 10, 2)->after('categoria')->nullable();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Elimina la columna 'precio' si se revierte la migración
            $table->dropColumn('precio');
        });
    }
};

