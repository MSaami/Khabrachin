<?php

namespace App\Repositories;

use DateTime;

class NewsFilterDTO extends GeneralDTO
{
    public ?string $search = null;
    public ?array $categories = null;
    public ?array $sources = null;
    public ?DateTime $date_from = null;
    public ?DateTime $date_to = null;
    public ?array $authors = null;
}
