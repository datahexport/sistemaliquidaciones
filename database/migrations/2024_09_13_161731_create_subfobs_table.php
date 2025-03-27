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
        Schema::create('subfobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fob_id')
            ->constrained()
            ->onDelete('cascade');

            $table->string('suma_fob')->nullable();
            $table->string('cant_kg')->nullable();
            $table->string('fob_kilo_salida')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subfobs');
    }
};
