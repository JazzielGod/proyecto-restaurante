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
        Schema::create('platillo_inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_platillo');
            $table->unsignedBigInteger('id_inventario');
            $table->double('cantidad')->nullable(false);
            $table->timestamps();
            
            $table->foreign('id_platillo')->references('id')->on('platillos')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_inventario')->references('id')->on('inventarios')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platillo_inventarios');
    }
};
