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
        Schema::create('razonsocials', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('rut')->nullable();
            $table->string('csg')->nullable();
            $table->string('informe')->nullable();
            $table->string('tc')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('razonsocials');
    }
};
