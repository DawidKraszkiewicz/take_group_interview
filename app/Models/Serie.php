<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tmdb_id
 * @property array $name
 * @property array $overview
 * @property string|null $poster_path
 * @property float|null $vote_average
 * @property \Illuminate\Support\Carbon|null $first_air_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Serie extends Model
{
    protected $fillable = [
        'tmdb_id',
        'name',
        'overview',
        'poster_path',
        'vote_average',
        'first_air_date',
    ];

    protected $casts = [
        'name' => 'array',
        'overview' => 'array',
        'first_air_date' => 'date',
    ];
}
