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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable(false)->unsigned();
            $table->integer('mesa')->nullable(true)->unique();
            $table->enum('tipo_orden', ['domicilio', 'restaurante'])->nullable(false);
            $table->string('direccion')->nullable(true);
            $table->date('fecha')->nullable(false);
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
