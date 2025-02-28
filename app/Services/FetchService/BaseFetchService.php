<?php

namespace App\Services\FetchService;

use Illuminate\Database\Eloquent\Model;

abstract class BaseFetchService implements INewsProvider
{
    protected array $config;
    protected Model $sourceModel;
    protected int $defaultPageSize = 50;
    protected int $page = 1;
}
