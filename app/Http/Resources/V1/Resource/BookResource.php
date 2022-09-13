<?php

namespace App\Http\Resources\V1\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'genre' => $this->when($this->genre, function() {
                return $this->genre->genre_name;
            }),
            'genre_id' => $this->when($this->genre, function() {
                return $this->genre->uuid;
            }),
            'author' => $this->when($this->author, function() {
                return $this->author->author_name;
            }),
            'author_id' => $this->when($this->author, function() {
                return $this->author->uuid;
            }),
            'publisher' => $this->when($this->publisher, function() {
                return $this->publisher->publisher_name;
            }),
            'publisher_id' => $this->when($this->publisher, function() {
                return $this->publisher->uuid;
            }),
            'gallery' => $this->when($this->gallery, function() {
                return asset('storage/'.$this->gallery->file_path);
            }),
            'gallery_id' => $this->when($this->gallery, function() {
                return $this->gallery->uuid;
            }),
            'isbn' => $this->isbn,
            'description' => $this->description,
            'published_at' => $this->published_at,
            'published_date' => $this->getAttributes()['published_at'],
            'created_at' => $this->created_at,
        ];
    }
}