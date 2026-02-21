<?php

namespace Tests\Feature;

use App\Jobs\FetchDataFromTmdbJob;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TmdbJobTest extends TestCase
{
    public function test_tmdb_command_dispatches_job()
    {
        Queue::fake();

        $this->artisan('tmdb:fetch')
            ->expectsOutput('Dispatching TMDB data fetch job...')
            ->expectsOutput('Job dispatched successfully.')
            ->assertExitCode(0);

        Queue::assertPushed(FetchDataFromTmdbJob::class);
    }
}
