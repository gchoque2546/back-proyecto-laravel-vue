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
        Schema::create('personas', function (Blueprint $table) {
            $table->id(); // id, ai, pk, bigInt, unsigned

            $table->string("nombres", 50);
            $table->string("apellidos", 50)->nullable();
            $table->string("ci_nit", 20)->nullable();
            $table->string("direccion")->nullable();
            $table->string("telefono", 20)->nullable();

            //relacion 1:1
            $table->bigInteger("user_id")->unsigned();
            //$table->unsignedBigInteger("user_id"); otra opcion
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps(); // created_at, update_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
