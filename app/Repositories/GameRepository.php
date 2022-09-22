<?php

namespace App\Repositories;
use App\Models\Game;
use App\Repositories\Interfaces\GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface 
{
    public function getAllGames()
    {
    	return Game::all();
    }
    
    public function destroyGame($id)
    {
    	Game::destroy($id);
    }

    public function createGame(array $data)
    {
    	$game = Game::create($data);
    	return $game;
    }

    public function updateGame(Game $game, array $data)
    {
    	$game->update($data);

    	return $game;
    }

    public function addGenres(Game $game, array $data)
    {
    	$game->genres()->sync(collect($data)->pluck('id'));

    	return $game;
    }
}