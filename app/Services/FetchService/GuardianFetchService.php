<?php

namespace App\Services\FetchService;

use App\Models\Source;
use App\Services\FetchService\DTO\FetchRequestDTO;
use App\Services\FetchService\DTO\NewsResponseDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GuardianFetchService extends BaseFetchService
{
    public function __construct()
    {
        $this->config = config('services.fetch_service.providers.guardian');
        $this->sourceModel = Source::where('name', $this->config['name'])->first();
    }

    public function fetch(FetchRequestDTO $fetchRequestDTO): array
    {
        $leftPage = true;

        $responseItems = [];

        while ($leftPage) {
            $response  = Http::get($this->config['url'], [
                'api-key' => $this->config['api_key'],
                'section' => $fetchRequestDTO->category_name,
                'from-date' => $fetchRequestDTO->from_date_time->toIso8601String(),
                'page-size' => $this->defaultPageSize,
                'page' => $this->page
            ]);

            if ($response->status() != 200) {
                throw new \Exception($response->json('response')['message']);
            }

            if ($response->json()['response']['pages'] == $this->page) {
                $leftPage = false;
            }

            $responseItems = array_merge($responseItems, $response->json()['response']['results']);

            $this->page++;
        }

        return $this->mapToDto($responseItems);
    }



    private function mapToDto(array $items): array
    {
        return array_map(function ($item) {
            $dto = new NewsResponseDTO();
            $dto->provider_id = $item['id'];
            $dto->title = $item['webTitle'];
            $dto->url = $item['webUrl'];
            $dto->published_at = Carbon::parse($item['webPublicationDate']);
            $dto->source_id = $this->sourceModel->id;
            return $dto;
        }, $items);
    }
}
