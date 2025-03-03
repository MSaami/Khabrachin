<?php

namespace App\Services\FetchService;

use App\Services\FetchService\DTO\FetchRequestDTO;
use Illuminate\Support\Facades\Http;

class GuardianFetchService extends BaseFetchService
{

    public const MAP_KEYS = [
        'provider_id' => 'id',
        'title' => 'webTitle',
        'url' => 'webUrl',
        'published_at' => 'webPublicationDate',
        'author' => 'fields.byline'
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
            'show-fields' => 'byline'
        ]);

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return $this->mapToDto($response->json('response.results'));
    }
}
