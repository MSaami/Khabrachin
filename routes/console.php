<?php

use App\Jobs\FetchNewsJob;
use App\Services\FetchService\GuardianFetchService;
use App\Services\FetchService\NewsFetchService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// $service = new NewsFetchService(new GuardianFetchService());
// Schedule::job(new FetchNewsJob($service))->everyTenSeconds();


// Schedule::command('news:fetch')
//     ->everyTenMinutes();
