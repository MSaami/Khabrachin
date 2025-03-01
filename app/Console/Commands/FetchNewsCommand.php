<?php

namespace App\Console\Commands;

use App\Jobs\FetchNewsJob;
use App\Services\FetchService\GuardianFetchService;
use App\Services\FetchService\NewsApiFetchService;
use App\Services\FetchService\NewsFetchService;
use App\Services\FetchService\NewYorkTimesFetchService;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch News From All Sources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new NewsFetchService(new GuardianFetchService());
        $service2 = new NewsFetchService(new NewsApiFetchService());
        $service3 = new NewsFetchService(new NewYorkTimesFetchService());

        $this->info('Guardian Fetching...');
        $service->execute();
        $this->info('Guardian Fetch Service executed');
        $this->info('NewsApi Fetching...');
        $service2->execute();
        $this->info('NewsApi Fetch Service executed');
        $this->info('New York Times Fetching...');
        $service3->execute();
        $this->info('New York Times Fetch Service executed');


        $this->info('News fetched successfully');
    }
}
