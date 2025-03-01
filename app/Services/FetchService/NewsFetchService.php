<?php


namespace App\Services\FetchService;

use App\Models\Category;
use App\Repositories\NewsRepository;
use App\Services\FetchService\DTO\FetchRequestDTO;
use Carbon\Carbon;

class NewsFetchService
{
    private NewsRepository $newsRepository;
    public function __construct(
        private INewsProvider $provider,
    ) {
        $this->newsRepository = resolve(NewsRepository::class);
    }

    public function execute()
    {
        foreach ($this->allCategories() as $category) {
            $dto = new FetchRequestDTO();
            $dto->from_date_time = $this->getLastFetchTime($category);
            $dto->category_name = $category->name;
            $data = $this->provider->fetch($dto);
            $this->newsRepository->store($category, $data);
        }
    }

    private function allCategories()
    {
        return Category::all();
    }

    private function getLastFetchTime(Category $category)
    {
        $lastNews = $this->newsRepository->getLastNewsByCategoryAndSource($category->id, $this->provider->config['name']);

        return $lastNews?->published_at ??  Carbon::now()->subHours(24);
    }
}
