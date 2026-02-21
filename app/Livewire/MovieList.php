<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class MovieList extends Component
{
    use WithPagination;

    public ?string $error = null;

    public function render()
    {
        try {
            $movies = Movie::paginate(12);
            return view('livewire.movie-list', [
                'movies' => $movies,
            ])->layout('layouts.app');
        } catch (\Exception $e) {
            Log::error('MovieList render error: ' . $e->getMessage());
            $this->error = 'Nie udało się załadować listy filmów. Spróbuj ponownie później.';
            return view('livewire.movie-list', [
                'movies' => null,
            ])->layout('layouts.app');
        }
    }
}
