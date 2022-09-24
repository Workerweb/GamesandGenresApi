<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'games_genres';

    protected $fillable = ['title'];

    protected $hidden = ['pivot'];
    
    public function games ()
    {
    	return $this->belongsToMany(Game::class, 'games_has_games_genres');
    }
}
