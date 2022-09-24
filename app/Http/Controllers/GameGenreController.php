<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\GameGenre\StoreGameGenreRequest;
use App\Http\Requests\GameGenre\UpdateGameGenreRequest;
use App\Http\Requests\GameGenre\AddGamesGenreRequest;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use App\Http\Resources\Genre\GenreResource;

class GameGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     * @OA\Get(
     *     path="/api/genres",
     *     tags={"Genres"},
     *     @OA\Response(
     *         response="200",
     *         description="Genres list"
     *     )
     * )
     */
    public function index(GenreRepositoryInterface $repository)
    {
        return GenreResource::collection($repository->getAllGenres());
    }

    /**
     * Create Genre
     * @OA\Post (
     *     path="/api/genres",
     *     tags={"Genres"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="stored",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      )
     * )
     */
    public function store(StoreGameGenreRequest $request, GenreRepositoryInterface $repository)
    {
        return (new GenreResource($repository->createGenre($request->validated())))
                    ->response()
                    ->setStatusCode(201);
    }

    /**
     * Get genre by id
     * @OA\Get (
     *     path="/api/genres/{genre_id}",
     *     tags={"Genres"},
     *     @OA\Parameter(
     *         in="path",
     *         name="genre_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="selected genre",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Record not found."),
     *          )
     *      )
     * )
     */
    public function show(Genre $genre)
    {
        return new GenreResource($genre);
    }

    /**
     * Update Genre
     * @OA\Put (
     *     path="/api/genres/{genre_id}",
     *     tags={"Genres"},
     *     @OA\Parameter(
     *         in="path",
     *         name="genre_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="updated",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Record not found."),
     *          )
     *      )
     * )
     */
    public function update(UpdateGameGenreRequest $request, Genre $genre, GenreRepositoryInterface $repository)
    {

        return new GenreResource($repository->updateGenre($genre, $request->validated()));
    }

    /**
     * Delete Genre
     * @OA\Delete (
     *     path="/api/genres/{genre_id}",
     *     tags={"Genres"},
     *     @OA\Parameter(
     *         in="path",
     *         name="genre_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="deleted")
     *         )
     *     )
     * )
     */
    public function destroy(Genre $genre, GenreRepositoryInterface $repository)
    {
        $repository->destroyGenre($genre->id);

        return response()->noContent();
    }

    /**
     * Add games to Genre
     * @OA\Post (
     *     path="/api/genres/{genre_id}/add-games",
     *     tags={"Genres"},
     *     @OA\Parameter(
     *         in="path",
     *         name="genre_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                      )
     *                    )
     *           )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="synced",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *                @OA\Property(
     *                property="games",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "name": "first game",
     *                  "description": "first game",
     *                  "created_at": "2021-12-11T09:25:53.000000Z",
     *                  "updated_at": "2021-12-11T09:25:53.000000Z"
     *                }, {
     *                  "id": 2,
     *                  "name": "second game",
     *                  "description": "second game",
     *                  "created_at": "2021-12-11T09:25:53.000000Z",
     *                  "updated_at": "2021-12-11T09:25:53.000000Z"
     *                }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=""
     *                      )
     *                   )
     *                ),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Record not found."),
     *          )
     *      )
     * )
     */
    public function addGames(AddGamesGenreRequest $request, Genre $genre, GenreRepositoryInterface $repository)
    {
        return new GenreResource($repository->addGames($genre, $request->validated())->load(['games']));
    }
}
