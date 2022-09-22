<?php

namespace App\Repositories\Interfaces;
use App\Models\Genre;

interface GenreRepositoryInterface 
{
    public function getAllGenres();
    public function destroyGenre($id);
    public function createGenre(array $data);
    public function updateGenre(Genre $genre, array $data);
    public function addGames(Genre $genre, array $data);
}