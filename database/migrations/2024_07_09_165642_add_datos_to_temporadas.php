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
             
            $table->string('proceso')->nullable();
            $table->string('pti')->nullable();
            $table->string('pti_terceros')->nullable();
            $table->string('tecomex')->nullable();
            $table->string('safe_cargo')->nullable();
            $table->string('transportes')->nullable();
            $table->string('coface')->nullable();
            $table->string('fedex')->nullable();
            $table->string('seguro_carga_fester')->nullable();
            $table->string('seguro_carga_maerk')->nullable();
            $table->string('asoex')->nullable();

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
