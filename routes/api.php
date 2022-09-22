<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameGenreController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('games', GameController::class);
Route::post('games/{game}/add-genres', [GameController::class, 'addGenres']);
Route::resource('genres', GameGenreController::class);
Route::post('genres/{genre}/add-games', [GameGenreController::class, 'addGames']);
