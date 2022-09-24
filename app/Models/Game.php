<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = ['name', 'description'];

    protected $hidden = ['pivot'];
    
    public function genres ()
    {
    	return $this->belongsToMany(Genre::class, 'games_has_games_genres');
    }
}
