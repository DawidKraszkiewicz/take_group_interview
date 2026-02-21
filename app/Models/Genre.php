<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tmdb_id
 * @property array $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Genre extends Model
{
    protected $fillable = [
        'tmdb_id',
        'name',
    ];

    protected $casts = [
        'name' => 'array',
    ];
}
