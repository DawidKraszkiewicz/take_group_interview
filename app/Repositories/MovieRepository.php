<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository
{
    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return Movie::paginate($perPage);
    }

    public function findById(int $id): Movie
    {
        return Movie::findOrFail($id);
    }
}
