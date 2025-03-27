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
        Schema::table('temporadas', function (Blueprint $table) {

            $table->string('procesocom')->nullable();
            $table->string('proceso10')->nullable();
            $table->string('proceso5')->nullable();
            $table->string('proceso25')->nullable();
            $table->string('proceso22')->nullable();
            
            $table->string('materiales10')->nullable();
            $table->string('materiales5')->nullable();
            $table->string('materiales25')->nullable();
            $table->string('materiales22')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporadas', function (Blueprint $table) {
            //
        });
    }
};
