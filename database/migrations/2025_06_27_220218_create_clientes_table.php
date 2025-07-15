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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo'); // Nombre completo del cliente
            $table->string('numero_id', 13); 
            $table->string('numero_telefono', 8); // Número de teléfono
            $table->string('correo_electronico'); // Correo electrónico
            $table->string('direccion_cliente'); // Dirección de envío
            $table->string('sexo'); // Sexo del cliente
            $table->date('fecha_ingreso')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('clientes', function (Blueprint $table) {
            // Revert the column to its previous state if necessary.
            // You might need to know the original length here.
            $table->string('numero_id', 13)->change(); // Example: revert to original 10
        });
    }
};