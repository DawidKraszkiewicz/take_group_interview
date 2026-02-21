<?php

namespace App\Services;

use App\Repositories\MovieRepository;
use Illuminate\Http\Request;

class MovieAppService
{
    protected $repository;

    public function __construct(MovieRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedMovies(Request $request)
    {
        $paginator = $this->repository->paginate(50);
        $lang = $this->getLanguage($request);

        $paginator->getCollection()->transform(function ($movie) use ($lang) {
            return [
                'id' => $movie->id,
                'tmdb_id' => $movie->tmdb_id,
                'title' => $movie->title[$lang] ?? $movie->title['en'] ?? null,
                'overview' => $movie->overview[$lang] ?? $movie->overview['en'] ?? null,
                'poster_path' => $movie->poster_path,
                'vote_average' => $movie->vote_average,
                'release_date' => $movie->release_date ? $movie->release_date->format('Y-m-d') : null,
            ];
        });

        return $paginator;
    }

    public function getMovieById(int $id, Request $request)
    {
        $movie = $this->repository->findById($id);
        $lang = $this->getLanguage($request);

        return [
            'data' => [
                'id' => $movie->id,
                'tmdb_id' => $movie->tmdb_id,
                'title' => $movie->title[$lang] ?? $movie->title['en'] ?? null,
                'overview' => $movie->overview[$lang] ?? $movie->overview['en'] ?? null,
                'poster_path' => $movie->poster_path,
                'vote_average' => $movie->vote_average,
                'release_date' => $movie->release_date ? $movie->release_date->format('Y-m-d') : null,
            ]
        ];
    }

    protected function getLanguage(Request $request): string
    {
        $lang = $request->header('Accept-Language', 'en');
        $shortLang = substr($lang, 0, 2);
        if (!in_array($shortLang, ['pl', 'en', 'de'])) {
            return 'en';
        }
        return $shortLang;
    }
}
