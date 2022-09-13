<?php

namespace App\Http\Resources\V1\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'file_path' => $this->when(true, function() {
                return asset('storage/'.$this->file_path);
            }),
            'file_type' => $this->file_type,
            'created_at' => $this->created_at,
        ];
    }
}
