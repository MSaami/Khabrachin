<?php


namespace App\Services\FetchService\DTO;

use Carbon\Carbon;

class NewsResponseDTO
{
    public string $title;
    public string $url;
    public string $source;
    public string $provider_id;
    public Carbon $published_at;

    public function getArray(): array
    {
        $result = json_encode($this);
        return json_decode($result, true);
    }
}
