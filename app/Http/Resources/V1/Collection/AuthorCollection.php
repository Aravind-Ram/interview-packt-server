<?php

namespace App\Http\Resources\V1\Collection;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\V1\Resource\AuthorResource;

class AuthorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status' => 'OK',
            'code' => 200,
            'message' => 'Author list fetched.',
            'data' => AuthorResource::collection($this->collection),
            'total' => $this->collection->count(),
            'meta' => [
                "current_page" => $this->currentPage(),
                "last_page" => $this->lastPage(),
                "per_page" => $this->perPage(),
                "total" => $this->total(),
                "current_items" => $this->count()
            ],
        ];
    }
}
