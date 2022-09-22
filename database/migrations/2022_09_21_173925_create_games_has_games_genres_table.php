<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesHasGamesGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_has_games_genres', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('genre_id');
            // $table->timestamps();
        });

        Schema::table('games_has_games_genres', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('games_genres')->onDelete('cascade');
            $table->unique(['game_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games_has_games_genres');
    }
}
