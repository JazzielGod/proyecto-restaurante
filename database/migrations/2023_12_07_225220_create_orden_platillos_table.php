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
        Schema::create('orden_platillos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('platillo_id');
            $table->integer('cantidad');
            $table->decimal('precio_platillo', 8, 2)->nullable(false);
            $table->timestamps();

            $table->foreign('orden_id')->references('id')->on('ordenes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('platillo_id')->references('id')->on('platillos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_platillos');
    }
};
