<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Http\Requests\Game\AddGenresGameRequest;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Http\Resources\Game\GameResource;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     * @OA\Get(
     *     path="/api/games",
     *     tags={"Games"},
     *     @OA\Response(
     *         response="200",
     *         description="Games list"
     *     )
     * )
     */
    public function index(GameRepositoryInterface $repository)
    {
        return GameResource::collection($repository->getAllGames());
    }

    /**
     * Create Game
     * @OA\Post (
     *     path="/api/games",
     *     tags={"Games"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="text"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"God of war",
     *                     "description":"Some words about this awesome game",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="stored",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="God of war"),
     *              @OA\Property(property="description", type="text", example="Some words about this awesome game"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      )
     * )
     */
    public function store(StoreGameRequest $request, GameRepositoryInterface $repository)
    {
        return (new GameResource($repository->createGame($request->validated())))
                    ->response()
                    ->setStatusCode(201);
    }

    /**
     * Get game by id
     * @OA\Get (
     *     path="/api/games/{game_id}",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         in="path",
     *         name="game_id",
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
     *          description="selected game",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="God of war"),
     *              @OA\Property(property="description", type="text", example="Some words about this awesome game"),
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
    public function show(Game $game)
    {
        return new GameResource($game);
    }

    /**
     * Update Game
     * @OA\Put (
     *     path="/api/games/{game_id}",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         in="path",
     *         name="game_id",
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
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="text"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"God of war",
     *                     "description":"Some words about this awesome game",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="updated",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="God of war"),
     *              @OA\Property(property="description", type="text", example="Some words about this awesome game"),
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
    public function update(UpdateGameRequest $request, Game $game, GameRepositoryInterface $repository)
    {
        return new GameResource($repository->updateGame($game, $request->validated()));
    }

    /**
     * Delete Game
     * @OA\Delete (
     *     path="/api/games/{game_id}",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         in="path",
     *         name="game_id",
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
    public function destroy(Game $game, GameRepositoryInterface $repository)
    {
        $repository->destroyGame($game->id);

        return response()->noContent();
    }

    /**
     * Add genres to Game
     * @OA\Post (
     *     path="/api/games/{game_id}/add-genres",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         in="path",
     *         name="game_id",
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
     *              @OA\Property(property="name", type="string", example="title"),
     *              @OA\Property(property="description", type="text", example="description"),
     *                @OA\Property(
     *                property="genres",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "title": "first genre",
     *                  "created_at": "2021-12-11T09:25:53.000000Z",
     *                  "updated_at": "2021-12-11T09:25:53.000000Z"
     *                }, {
     *                  "id": 2,
     *                  "title": "second genre",
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
    public function addGenres(AddGenresGameRequest $request, Game $game, GameRepositoryInterface $repository)
    {
        return new GameResource($repository->addGenres($game, $request->validated())->load(['genres']));
    }
}
