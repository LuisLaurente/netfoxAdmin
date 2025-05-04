<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_accion'); // crear, editar, eliminar, transferir
            $table->string('modelo'); // cuenta, usuario
            $table->unsignedBigInteger('modelo_id');
            $table->text('datos_previos')->nullable();
            $table->text('datos_nuevos')->nullable();
            $table->unsignedBigInteger('usuario_sistema_id')->nullable(); // quien realizó la acción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
