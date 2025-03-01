<?php


namespace App\Services\FetchService;

use App\Models\Source;
use App\Services\FetchService\DTO\FetchRequestDTO;
use Illuminate\Support\Facades\Http;

class NewsApiFetchService extends BaseFetchService
{
    protected int $defaultPageSize = 100;

    //it can have a database table to make it more dynamic, it can be caused exception if the category is not found
    //for now, it is hardcoded
    private const CATEGORY_MAPPER = [
        'sport' => 'news/Sports',
        'entertainment' => 'dmoz/Arts/Entertainment',
        'arts' => 'dmoz/Arts',
        'world' => 'dmoz/Arts/Literature/World_Literature',
        'technology' => 'dmoz/Computers/Internet',
    ];


    protected const MAP_KEYS = [
        'provider_id' => 'uri',
        'title' => 'title',
        'url' => 'url',
        'published_at' => 'dateTimePub',
    ];


    public function __construct()
    {
        $this->config = config('services.fetch_service.providers.newsapi');
    }

    public function fetch(FetchRequestDTO $fetchRequestDTO): array
    {

        $response = Http::get($this->config['url'], [
            'apiKey' => $this->config['api_key'],
            'category' => self::CATEGORY_MAPPER[$fetchRequestDTO->category_name],
            'dateStart' => $fetchRequestDTO->from_date_time->format('Y-m-d'),
            'articlesCount' => $this->defaultPageSize,
            'lang' => 'eng'
        ]);
        
        if(!$response->successful()) {
            throw new \Exception($response->body());
        }
        return $this->mapToDto($response->json('articles.results'));
    }
}
