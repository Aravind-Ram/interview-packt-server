<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Uuid;

class Publisher extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publisher_name',
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
}
