<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Serie;

class SeriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_series()
    {
        Serie::create([
            'tmdb_id' => 123,
            'name' => ['en' => 'Test Serie', 'pl' => 'Serial Testowy'],
            'overview' => ['en' => 'Test Overview', 'pl' => 'Opis Testowy'],
            'vote_average' => 8.5,
            'first_air_date' => '2023-01-01',
        ]);

        $response = $this->getJson('/api/series');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'tmdb_id',
                        'name',
                        'overview',
                        'poster_path',
                        'vote_average',
                        'first_air_date',
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]);
    }

    public function test_serie_localization_header()
    {
        $serie = Serie::create([
            'tmdb_id' => 456,
            'name' => ['en' => 'English Title', 'pl' => 'Polski Tytuł'],
            'overview' => ['en' => 'English Overview', 'pl' => 'Polski Opis'],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'pl'])
            ->getJson("/api/series/{$serie->id}");

        $response->assertStatus(200)
             ->assertJsonPath('data.name', 'Polski Tytuł');
             
        $responseEn = $this->withHeaders(['Accept-Language' => 'fr']) 
            ->getJson("/api/series/{$serie->id}");
            
        $responseEn->assertStatus(200)
             ->assertJsonPath('data.name', 'English Title');
    }

    public function test_serie_not_found_returns_404_json()
    {
        $response = $this->getJson('/api/series/999999');

        $response->assertStatus(404)
                 ->assertJsonStructure(['message', 'error'])
                 ->assertJsonPath('error', 'not_found');
    }
}
