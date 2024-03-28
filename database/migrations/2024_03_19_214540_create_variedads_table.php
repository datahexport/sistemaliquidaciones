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
        Schema::create('variedads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

                $table->string('name');
                $table->string('cajabulto')->nullable();
                $table->string('kilosnetos')->nullable();
                $table->string('cajasbase')->nullable();
                $table->string('totalfob')->nullable();
                $table->string('totalcomision')->nullable();
                $table->string('totalfrio')->nullable();
                $table->string('totalexportacion')->nullable();
                $table->string('totalflete')->nullable();
                $table->string('totalmateriales')->nullable();
                $table->string('retornoproductor')->nullable();
                $table->string('retornokg')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variedads');
    }
};
