<?php

namespace App\Services\FetchService;

use App\Services\FetchService\DTO\FetchRequestDTO;

interface INewsProvider
{
    public function fetch(FetchRequestDTO $fetchRequestDTO): array;
}
