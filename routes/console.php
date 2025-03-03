<?php

use App\Jobs\FetchNewsJob;
use App\Services\FetchService\GuardianFetchService;
use App\Services\FetchService\NewsApiFetchService;
use App\Services\FetchService\NewsFetchService;
use App\Services\FetchService\NewYorkTimesFetchService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


$serviceGuardian = new NewsFetchService(new GuardianFetchService());
Schedule::job(new FetchNewsJob($serviceGuardian))->everyTenSeconds();

$serviceNewsApi = new NewsFetchService(new NewsApiFetchService());
Schedule::job(new FetchNewsJob($serviceNewsApi))->everyTenSeconds();

$serviceNewYorkTimes = new NewsFetchService(new NewYorkTimesFetchService());
Schedule::job(new FetchNewsJob($serviceNewYorkTimes))->everyMinute();
