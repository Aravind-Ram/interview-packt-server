<?php

namespace App\Http\Resources\V1\Collection;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\V1\Resource\BookResource;

class BookCollection extends ResourceCollection
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
            'message' => 'Book list fetched.',
            'data' => BookResource::collection($this->collection),
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
