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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable(false)->unsigned();
            $table->string('nombre', 50)->nullable(false)->unique();
            $table->decimal('cantidad', 8, 3)->nullable(false);
            $table->decimal('cantidad_minima', 8, 3)->nullable(false);
            $table->string('tipo', 100)->nullable(false);
            $table->string('unidad_medida', 10)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
