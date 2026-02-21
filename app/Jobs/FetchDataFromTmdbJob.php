<?php

namespace App\Jobs;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Serie;
use App\Services\TmdbService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchDataFromTmdbJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tmdbService;

    public function __construct()
    {
    }

    public function handle(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;

        Log::info('Starting TMDB data fetch...');

        try {
            $languages = ['pl', 'en', 'de'];

            $this->fetchGenres($languages);
            $this->fetchMovies($languages, 50);
            $this->fetchSeries($languages, 10);

            Log::info('TMDB data fetch completed.');
        } catch (\Exception $e) {
            Log::error('FetchDataFromTmdbJob failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            $this->fail($e);
        }
    }

    protected function fetchGenres($languages)
    {
        $genres = $this->tmdbService->fetchGenres($languages);

        foreach ($genres as $data) {
            Genre::updateOrCreate(
                ['tmdb_id' => $data['tmdb_id']],
                ['name' => $data['name']]
            );
        }
    }

    protected function fetchMovies($languages, $limit)
    {
        $movies = $this->tmdbService->fetchMovies($limit, $languages);

        foreach ($movies as $movieData) {
            Movie::updateOrCreate(
                ['tmdb_id' => $movieData['tmdb_id']],
                $movieData
            );
        }
    }

    protected function fetchSeries($languages, $limit)
    {
        $series = $this->tmdbService->fetchSeries($limit, $languages);

        foreach ($series as $serieData) {
            Serie::updateOrCreate(
                ['tmdb_id' => $serieData['tmdb_id']],
                $serieData
            );
        }
    }
}
