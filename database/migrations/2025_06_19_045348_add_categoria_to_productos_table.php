<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Verifica si la columna 'categoria' no existe antes de agregarla
            if (!Schema::hasColumn('productos', 'categoria')) {
                $table->string('categoria', 30)->after('stock')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Asegúrate de que la columna exista antes de intentar eliminarla
            if (Schema::hasColumn('productos', 'categoria')) {
                $table->dropColumn('categoria');
            }
        });
    }
};