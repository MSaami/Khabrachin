<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\News;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;
    private const SOURCES = [
        'newsapi',
        'new-york-times',
        'guardian',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'provider_id' => $this->faker->uuid,
            'category_id' => Category::factory(),
            'source' => self::SOURCES[array_rand(self::SOURCES)],
            'author' => $this->faker->name,
            'url' => $this->faker->url,
            'published_at' => Carbon::now()->subDays(rand(1, 30)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
