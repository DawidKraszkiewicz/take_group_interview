<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Movie;

class MoviesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_movies()
    {
        Movie::create([
            'tmdb_id' => 123,
            'title' => ['en' => 'Test Movie', 'pl' => 'Film Testowy'],
            'overview' => ['en' => 'Test Overview', 'pl' => 'Opis Testowy'],
            'vote_average' => 8.5,
            'release_date' => '2023-01-01',
        ]);

        $response = $this->getJson('/api/movies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'tmdb_id',
                        'title',
                        'overview',
                        'poster_path',
                        'vote_average',
                        'release_date',
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

    public function test_movie_localization_header()
    {
        $movie = Movie::create([
            'tmdb_id' => 456,
            'title' => ['en' => 'English Title', 'pl' => 'Polski Tytuł'],
            'overview' => ['en' => 'English Overview', 'pl' => 'Polski Opis'],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'pl'])
            ->getJson("/api/movies/{$movie->id}");

        $response->assertStatus(200)
             ->assertJsonPath('data.title', 'Polski Tytuł');
             
        $responseEn = $this->withHeaders(['Accept-Language' => 'fr']) 
            ->getJson("/api/movies/{$movie->id}");
            
        $responseEn->assertStatus(200)
             ->assertJsonPath('data.title', 'English Title');
    }

    public function test_movie_not_found_returns_404_json()
    {
        $response = $this->getJson('/api/movies/999999');

        $response->assertStatus(404)
                 ->assertJsonStructure(['message', 'error'])
                 ->assertJsonPath('error', 'not_found');
    }
}
