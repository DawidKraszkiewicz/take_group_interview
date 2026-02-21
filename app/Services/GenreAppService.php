<?php

namespace App\Services;

use App\Repositories\GenreRepository;
use Illuminate\Http\Request;

class GenreAppService
{
    protected $repository;

    public function __construct(GenreRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedGenres(Request $request)
    {
        $paginator = $this->repository->paginate(50);
        $lang = $this->getLanguage($request);

        $paginator->getCollection()->transform(function ($genre) use ($lang) {
            return [
                'id' => $genre->id,
                'tmdb_id' => $genre->tmdb_id,
                'name' => $genre->name[$lang] ?? $genre->name['en'] ?? null,
            ];
        });

        return $paginator;
    }

    public function getGenreById(int $id, Request $request)
    {
        $genre = $this->repository->findById($id);
        $lang = $this->getLanguage($request);

        return [
            'data' => [
                'id' => $genre->id,
                'tmdb_id' => $genre->tmdb_id,
                'name' => $genre->name[$lang] ?? $genre->name['en'] ?? null,
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
