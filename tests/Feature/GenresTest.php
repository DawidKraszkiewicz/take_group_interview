<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Genre;

class GenresTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_genres()
    {
        Genre::create([
            'tmdb_id' => 123,
            'name' => ['en' => 'Action', 'pl' => 'Akcja'],
        ]);

        $response = $this->getJson('/api/genres');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'tmdb_id',
                        'name',
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

    public function test_genre_localization_header()
    {
        $genre = Genre::create([
            'tmdb_id' => 456,
            'name' => ['en' => 'English Name', 'pl' => 'Polska Nazwa'],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'pl'])
            ->getJson("/api/genres/{$genre->id}");

        $response->assertStatus(200)
             ->assertJsonPath('data.name', 'Polska Nazwa');
             
        $responseEn = $this->withHeaders(['Accept-Language' => 'fr']) 
            ->getJson("/api/genres/{$genre->id}");
            
        $responseEn->assertStatus(200)
             ->assertJsonPath('data.name', 'English Name');
    }

    public function test_genre_not_found_returns_404_json()
    {
        $response = $this->getJson('/api/genres/999999');

        $response->assertStatus(404)
                 ->assertJsonStructure(['message', 'error'])
                 ->assertJsonPath('error', 'not_found');
    }
}
