<?php

namespace App\Http\Resources\V1\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
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
            'uuid' => $this->uuid,
            'genre_name' => $this->genre_name,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
