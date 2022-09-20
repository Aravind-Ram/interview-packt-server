<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use App\Traits\Uuid;


class Book extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'genre_id',
        'publisher_id',
        'description',
        'isbn',
        'gallery_id',
        'published_at',
    ];

    protected $hidden = [
        'id',
        'author_id',
        'genre_id',
        'publisher_id',
        'deleted_at',
        'updated_at'
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date(DISPLAY_DATETIME_FORMAT, strtotime($value)) : null,
        );
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date(DISPLAY_DATETIME_FORMAT, strtotime($value)) : null,
            set: fn ($value) => $value ? date(DB_DATETIME_FORMAT, strtotime($value)) : null,
        );
    }

    public function genre()
    {
        return $this->hasOne(Genre::class, 'id', 'genre_id');
    }

    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'id', 'gallery_id');
    }

    
    public function publisher()
    {
        return $this->hasOne(Publisher::class, 'id', 'publisher_id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $slugValue = Str::slug($value);
        if (static::whereSlug($slugValue)->exists()) {

            $slugValue = $this->incrementSlug($slugValue);
        }
        $this->attributes['slug'] = Str::slug($value);
    }

    public function incrementSlug($slug) {
        $original = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
    
            $slug = "{$original}-" . $count++;
        }
        return $slug;    
    }
}