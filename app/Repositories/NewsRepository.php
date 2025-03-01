<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;

class NewsRepository
{
    public function getNews(NewsFilterDTO $newsfilterDTO)
    {
        return News::with(['category'])
            ->category($newsfilterDTO->categories)
            ->source($newsfilterDTO->sources)
            ->search($newsfilterDTO->search)
            ->dateFrom($newsfilterDTO->date_from)
            ->dateTo($newsfilterDTO->date_to)
            ->orderBy('published_at', 'desc')
            ->paginate();
    }

    public function getLastNewsByCategoryAndSource(int $categoryId, string $source)
    {
        return News::where('category_id', $categoryId)
            ->where('source', $source)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    public function store(Category $category, array $news)
    {
        $manipulatedData = array_map(function ($item) use ($category) {
            return [
                'title' => $item->title,
                'provider_id' => $item->provider_id,
                'category_id' => $category->id,
                'source' => $item->source,
                'url' => $item->url,
                'published_at' => $item->published_at,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }, $news);

        News::insertOrIgnore($manipulatedData);
    }
}
