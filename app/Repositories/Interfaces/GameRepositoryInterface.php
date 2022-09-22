<?php

namespace App\Repositories\Interfaces;
use App\Models\Game;

interface GameRepositoryInterface 
{
    public function getAllGames();
    public function destroyGame($id);
    public function createGame(array $data);
    public function updateGame(Game $game, array $data);
    public function addGenres(Game $game, array $data);
}