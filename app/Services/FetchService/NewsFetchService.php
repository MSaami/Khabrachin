<?php


namespace App\Services\FetchService;

use App\Models\Category;
use App\Services\FetchService\DTO\FetchRequestDTO;
use Carbon\Carbon;

class NewsFetchService
{
    private INewsProvider $provider;

    public function __construct(INewsProvider $provider)
    {
        $this->provider = $provider;
    }

    public function execute()
    {

        $dto = new FetchRequestDTO();
        $dto->from_date_time = Carbon::now()->subHours(24);
        $dto->category_name = 'sport';

        $data = $this->provider->fetch($dto);

        $category = Category::where('name', $dto->category_name)->first();

        $data = array_map(function ($item) {
            return $item->getArray();
        }, $data);

        $category->news()->createMany($data);
    }
}
