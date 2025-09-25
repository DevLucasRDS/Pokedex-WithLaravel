<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('team_pokemon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('pokemon_id');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('pokemon_id')->references('id')->on('pokemon')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_pokemon');
    }
};
