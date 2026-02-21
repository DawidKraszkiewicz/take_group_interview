<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $baseUrl = 'https://api.themoviedb.org/3';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key', env('TMDB_API_KEY'));
    }

    public function fetchGenres(array $languages): array
    {
        $genreData = [];

        foreach ($languages as $lang) {
            $movies = $this->fetch('genre/movie/list', ['language' => $lang]);
            if (isset($movies['genres'])) {
                foreach ($movies['genres'] as $g) {
                    $genreData[$g['id']]['tmdb_id'] = $g['id'];
                    $genreData[$g['id']]['name'][$lang] = $g['name'];
                }
            }
            
            $tv = $this->fetch('genre/tv/list', ['language' => $lang]);
            if (isset($tv['genres'])) {
                foreach ($tv['genres'] as $g) {
                    $genreData[$g['id']]['tmdb_id'] = $g['id'];
                    $genreData[$g['id']]['name'][$lang] = $g['name'];
                }
            }
        }

        return $genreData;
    }

    public function fetchMovies(int $limit, array $languages): array
    {
        $movieIds = [];
        $page = 1;
        while (count($movieIds) < $limit) {
            $response = $this->fetch('movie/popular', ['page' => $page, 'language' => 'en']);
            if (!$response || !isset($response['results'])) break;
            
            foreach ($response['results'] as $movie) {
                if (!in_array($movie['id'], $movieIds)) {
                    $movieIds[] = $movie['id'];
                }
                if (count($movieIds) >= $limit) break;
            }
            $page++;
            if ($page > 5) break;
        }

        $allMovieData = [];

        foreach ($movieIds as $id) {
            $movieData = [
                'tmdb_id' => $id,
                'title' => [],
                'overview' => [],
                'poster_path' => null,
                'vote_average' => null,
                'release_date' => null,
            ];

            foreach ($languages as $lang) {
                $details = $this->fetch("movie/{$id}", ['language' => $lang]);
                if ($details) {
                    $movieData['title'][$lang] = $details['title'] ?? '';
                    $movieData['overview'][$lang] = $details['overview'] ?? '';
                    
                    if ($lang === 'en' || !$movieData['poster_path']) {
                        $movieData['poster_path'] = $details['poster_path'] ?? null;
                        $movieData['vote_average'] = $details['vote_average'] ?? null;
                        $movieData['release_date'] = $details['release_date'] ?? null;
                    }
                }
            }
            $allMovieData[] = $movieData;
        }

        return $allMovieData;
    }

    public function fetchSeries(int $limit, array $languages): array
    {
        $serieIds = [];
        $page = 1;
        while (count($serieIds) < $limit) {
            $response = $this->fetch('tv/popular', ['page' => $page, 'language' => 'en']);
            if (!$response || !isset($response['results'])) break;
            
            foreach ($response['results'] as $serie) {
                if (!in_array($serie['id'], $serieIds)) {
                    $serieIds[] = $serie['id'];
                }
                if (count($serieIds) >= $limit) break;
            }
            $page++;
            if ($page > 5) break; 
        }

        $allSerieData = [];

        foreach ($serieIds as $id) {
            $serieData = [
                'tmdb_id' => $id,
                'name' => [],
                'overview' => [],
                'poster_path' => null,
                'vote_average' => null,
                'first_air_date' => null,
            ];

            foreach ($languages as $lang) {
                $details = $this->fetch("tv/{$id}", ['language' => $lang]);
                if ($details) {
                    $serieData['name'][$lang] = $details['name'] ?? '';
                    $serieData['overview'][$lang] = $details['overview'] ?? '';
                    
                    if ($lang === 'en' || !$serieData['poster_path']) {
                        $serieData['poster_path'] = $details['poster_path'] ?? null;
                        $serieData['vote_average'] = $details['vote_average'] ?? null;
                        $serieData['first_air_date'] = $details['first_air_date'] ?? null;
                    }
                }
            }
            $allSerieData[] = $serieData;
        }

        return $allSerieData;
    }

    protected function fetch($endpoint, $params = [])
    {
        $params['api_key'] = $this->apiKey;
        
        $response = Http::get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->failed()) {
            Log::error("TMDB API Error: " . $response->body());
            return null;
        }

        return $response->json();
    }
}
