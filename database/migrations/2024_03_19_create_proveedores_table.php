<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa');
            $table->string('pais_origen');
            $table->string('persona_contacto');
            $table->string('correo_electronico');
            $table->string('telefono_contacto');
            $table->string('direccion');
            $table->json('marcas');
            $table->json('tipo_autopartes');
            $table->string('persona_contacto_secundaria')->nullable();
            $table->string('telefono_contacto_secundario')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}; 