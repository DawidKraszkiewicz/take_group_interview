<?php

namespace App\Services;

use App\Repositories\SerieRepository;
use Illuminate\Http\Request;

class SerieAppService
{
    protected $repository;

    public function __construct(SerieRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedSeries(Request $request)
    {
        $paginator = $this->repository->paginate(10);
        $lang = $this->getLanguage($request);

        $paginator->getCollection()->transform(function ($serie) use ($lang) {
            return [
                'id' => $serie->id,
                'tmdb_id' => $serie->tmdb_id,
                'name' => $serie->name[$lang] ?? $serie->name['en'] ?? null,
                'overview' => $serie->overview[$lang] ?? $serie->overview['en'] ?? null,
                'poster_path' => $serie->poster_path,
                'vote_average' => $serie->vote_average,
                'first_air_date' => $serie->first_air_date ? $serie->first_air_date->format('Y-m-d') : null,
            ];
        });

        return $paginator;
    }

    public function getSerieById(int $id, Request $request)
    {
        $serie = $this->repository->findById($id);
        $lang = $this->getLanguage($request);

        return [
            'data' => [
                'id' => $serie->id,
                'tmdb_id' => $serie->tmdb_id,
                'name' => $serie->name[$lang] ?? $serie->name['en'] ?? null,
                'overview' => $serie->overview[$lang] ?? $serie->overview['en'] ?? null,
                'poster_path' => $serie->poster_path,
                'vote_average' => $serie->vote_average,
                'first_air_date' => $serie->first_air_date ? $serie->first_air_date->format('Y-m-d') : null,
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
