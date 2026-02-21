<?php

namespace App\Repositories;

use App\Models\Serie;
use Illuminate\Pagination\LengthAwarePaginator;

class SerieRepository
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Serie::paginate($perPage);
    }

    public function findById(int $id): Serie
    {
        return Serie::findOrFail($id);
    }
}
