<?php


namespace App\Services\FetchService\DTO;

use Carbon\Carbon;

class FetchRequestDTO
{
    public Carbon $from_date_time;
    public string $category_name;
}
