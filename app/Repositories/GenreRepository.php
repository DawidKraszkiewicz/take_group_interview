<?php

namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreRepository
{
    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return Genre::paginate($perPage);
    }

    public function findById(int $id): Genre
    {
        return Genre::findOrFail($id);
    }
}
