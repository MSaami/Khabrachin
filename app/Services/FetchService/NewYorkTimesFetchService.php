<?php

namespace App\Services\FetchService;

use App\Services\FetchService\DTO\FetchRequestDTO;
use Illuminate\Support\Facades\Http;

class NewYorkTimesFetchService extends BaseFetchService
{

    public const MAP_KEYS = [
        'provider_id' => '_id',
        'title' => 'abstract',
        'url' => 'web_url',
        'published_at' => 'pub_date',
        'author' => 'byline.original.'
    ];

    public function __construct()
    {
        $this->config = config('services.fetch_service.providers.new-york-times');
    }

    public function fetch(FetchRequestDTO $fetchRequestDTO): array
    {

        $response = Http::get($this->config['url'] . '?' . $this->buildQuery($fetchRequestDTO));

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return $this->mapToDto($response->json('response.docs'));
    }


    private function buildQuery(FetchRequestDTO $fetchRequestDTO)
    {

        return http_build_query([
            'api-key' => $this->config['api_key'],
            'fq' => 'section_name:("' . $fetchRequestDTO->category_name . '")' . ' AND ' . 'pub_date:{"' . $fetchRequestDTO->from_date_time->toIso8601String()  . '" TO *}'
        ]);
    }
}
