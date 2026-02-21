<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchTmdbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch movies, series and genres from TMDB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Dispatching TMDB data fetch job...');
        \App\Jobs\FetchDataFromTmdbJob::dispatch();
        $this->info('Job dispatched successfully.');
    }
}
