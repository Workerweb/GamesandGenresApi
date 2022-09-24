<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Genre\GenreResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
