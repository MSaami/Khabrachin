<?php 

namespace Tests\Unit\Repositories;

use App\Models\Category;
use App\Models\News;
use App\Models\Source;
use App\Repositories\NewsFilterDTO;
use App\Repositories\NewsRepository;
use App\Services\FetchService\DTO\NewsResponseDTO;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected NewsRepository $newsRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->newsRepository = new NewsRepository();
    }

    public function testGetNews()
    {
        $category = Category::factory()->create();
        $news = News::factory()->create([
            'category_id' => $category->id,
            'published_at' => Carbon::now(),
        ]);

        $dto = new NewsFilterDTO();
        $dto->categories = [$category->id];
        $dto->sources = [$news->source];
        $dto->date_from = Carbon::now()->subDay();
        $dto->date_to = Carbon::now()->addDay();
        $dto->search = '';

        $news = $this->newsRepository->getNews($dto);

        $this->assertCount(1, $news);
    }

    public function testGetNewsWithNoResults()
    {
        $dto = new NewsFilterDTO();
        $dto->categories = [782];
        $dto->sources = ['sourceDoesNotExist'];
        $dto->date_from = Carbon::now()->subDay();
        $dto->date_to = Carbon::now()->addDay();
        $dto->search = '';

        $news = $this->newsRepository->getNews($dto);

        $this->assertCount(0, $news);
    }

    public function testGetLastNewsByCategoryAndSource()
    {
        $category = Category::factory()->create();
        $news = News::factory()->create([
            'category_id' => $category->id,
            'published_at' => Carbon::now(),
        ]);

        $lastNews = $this->newsRepository->getLastNewsByCategoryAndSource($category->id, $news->source);

        $this->assertNotNull($lastNews);
        $this->assertEquals($news->id, $lastNews->id);
    }

    public function testGetLastNewsByCategoryAndSourceWithNoResults()
    {
        $lastNews = $this->newsRepository->getLastNewsByCategoryAndSource(999, 999); 

        $this->assertNull($lastNews);
    }

    public function testStore()
    {
        $category = Category::factory()->create();
        $dto = new NewsResponseDTO;
        $dto->title = 'Test News';
        $dto->provider_id = 1;
        $dto->source = 'guardian';
        $dto->url = 'http://example.com';
        $dto->published_at = Carbon::now();


        $newsData = [
            $dto
        ];

        $this->newsRepository->store($category, $newsData);

        $this->assertDatabaseHas('news', [
            'title' => 'Test News',
            'category_id' => $category->id,
        ]);
    }

    public function testStoreWithEmptyNewsArray()
    {
        $category = Category::factory()->create();
        $newsData = [];

        $this->newsRepository->store($category, $newsData);

        $this->assertDatabaseCount('news', 0);
    }
}