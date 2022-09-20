<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use App\Traits\Uuid;

class Author extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_name',
        'slug',
        'email',
        'phone_number',
        'address',
        'status',
    ];

    protected $hidden = [
        'id',
        'deleted_at',
        'updated_at'
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date(DISPLAY_DATETIME_FORMAT, strtotime($value)) : null,
        );
    }

    public function setAuthorNameAttribute($value)
    {
        $this->attributes['author_name'] = $value;
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
