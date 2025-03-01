<?php

namespace App\Services\FetchService;

use App\Services\FetchService\DTO\NewsResponseDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class BaseFetchService implements INewsProvider
{
    public array $config;
    protected int $defaultPageSize = 50;


    protected function mapToDto(array $items): array
    {
        return array_map(function ($item) {
            $dto = new NewsResponseDTO();
            $dto->provider_id = $item[static::MAP_KEYS['provider_id']];
            $dto->title = $item[static::MAP_KEYS['title']];
            $dto->url = $item[static::MAP_KEYS['url']];
            $dto->published_at = Carbon::parse($item[static::class::MAP_KEYS['published_at']]);
            $dto->source = $this->config['name'];
            return $dto;
        }, $items);
    }
}
