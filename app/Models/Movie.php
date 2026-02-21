<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tmdb_id
 * @property array $title
 * @property array $overview
 * @property string|null $poster_path
 * @property float|null $vote_average
 * @property \Illuminate\Support\Carbon|null $release_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Movie extends Model
{
    protected $fillable = [
        'tmdb_id',
        'title',
        'overview',
        'poster_path',
        'vote_average',
        'release_date',
    ];

    protected $casts = [
        'title' => 'array',
        'overview' => 'array',
        'release_date' => 'date',
    ];
}
