<?php

namespace App\Services\FetchService;

use App\Models\Source;
use App\Services\FetchService\DTO\FetchRequestDTO;
use Illuminate\Support\Facades\Http;

class GuardianFetchService extends BaseFetchService
{

    const MAP_KEYS = [
        'provider_id' => 'id',
        'title' => 'webTitle',
        'url' => 'webUrl',
        'published_at' => 'webPublicationDate',
    ];

    public function __construct()
    {
        $this->config = config('services.fetch_service.providers.guardian');
    }

    public function fetch(FetchRequestDTO $fetchRequestDTO): array
    {
        $response  = Http::get($this->config['url'], [
            'api-key' => $this->config['api_key'],
            'section' => $fetchRequestDTO->category_name,
            'from-date' => $fetchRequestDTO->from_date_time->toIso8601String(),
            'page-size' => $this->defaultPageSize,
        ]);

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return $this->mapToDto($response->json('response.results'));
    }
}
