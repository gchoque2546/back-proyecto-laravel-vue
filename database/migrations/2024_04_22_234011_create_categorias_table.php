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
        Schema::create('categorias', function (Blueprint $table) {
            //unique->para que el valor sea unico
            //nullable puede ser un valor nulo
            //softDeletes->para eliminar datos de forma temporal con opcion a recuperar datos
            $table->id();
            $table->string("nombre", 30)->unique();
            $table->text("detalle")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
