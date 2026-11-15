<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('altura')->nullable();
            $table->integer('masa')->nullable();
            $table->string('color_cabello')->nullable();
            $table->string('color_ojos')->nullable();
            $table->string('genero');
            $table->string('planeta_origen')->nullable();
            $table->boolean('origen_swapi')->default(false);
            $table->integer('swapi_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personajes');
    }
};
