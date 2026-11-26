<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('tipo', 50);
            $table->string('imagem', 255)->nullable();
            $table->json('poderes')->nullable();
            $table->json('fraquezas')->nullable();
            $table->timestamps();

            $table->index(['nome', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};
