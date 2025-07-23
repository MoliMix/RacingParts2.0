<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->year('anio');
            $table->string('categoria', 30);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2); // ✅ Campo precio agregado
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
