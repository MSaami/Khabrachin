<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use App\Models\UserPreferences;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testFetchNewsWithoutUserPreferences(): void
    {
        News::factory()->count(10)->create();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('news.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function testFetchNewsWithCategoryFilter()
    {
        $category1 = Category::factory()->create();
        News::factory()->count(7)->create([
            'category_id' => $category1->id,
        ]);
        $category2 = Category::factory()->create();
        News::factory()->count(3)->create([
            'category_id' => $category2->id,
        ]);
        
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('news.index', ['categories' => $category1->id]));

        $response->assertStatus(200);
        $response->assertJsonCount(7, 'data');
    }

    public function testFetchNewsWithPreferences()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $category3 = Category::factory()->create();

        News::factory()->count(5)->create([
            'category_id' => $category1->id,
        ]);
        News::factory()->count(3)->create([
            'category_id' => $category2->id,
        ]);
        News::factory()->count(2)->create([
            'category_id' => $category3->id,
        ]);

        $user = User::factory()->create();
        UserPreferences::create([
            'user_id' => $user->id,
            'category_ids' => [$category1->id, $category2->id],
        ]);


        $this->actingAs($user);
        $response = $this->get(route('news.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(8, 'data');
    }
}

