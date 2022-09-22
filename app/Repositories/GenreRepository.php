<?php

namespace App\Repositories;
use App\Models\Genre;
use App\Repositories\Interfaces\GenreRepositoryInterface;

class GenreRepository implements GenreRepositoryInterface 
{
    public function getAllGenres()
    {
    	return Genre::all();
    }
    
    public function destroyGenre($id)
    {
    	Genre::destroy($id);
    }

    public function createGenre(array $data)
    {
    	$genre = Genre::create($data);
    	return $genre;
    }

    public function updateGenre(Genre $genre, array $data)
    {
    	$genre->update($data);

    	return $genre;
    }

    public function addGames(Genre $genre, array $data)
    {
    	$genre->games()->sync(collect($data)->pluck('id'));

    	return $genre;
    }
}