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
        Schema::create('platillos', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable(false)->unsigned();
            $table->string('nombre', 50)->nullable(false)->unique();
            $table->string('descripcion', 100)->nullable(false);
            $table->decimal('precio', 8, 2)->nullable(false);
            $table->string('imagen_path', 255)->nullable(true)->default(asset('/public/default.png'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platillos');
    }
};
