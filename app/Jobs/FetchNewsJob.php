<?php

namespace App\Jobs;

use App\Services\FetchService\NewsFetchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchNewsJob implements ShouldQueue
{
    use Queueable;


    public function __construct(private NewsFetchService $newsFetchService) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->newsFetchService->execute();
    }
}
