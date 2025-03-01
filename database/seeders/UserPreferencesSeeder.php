<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Source;
use App\Models\UserPreferences;
use Illuminate\Database\Seeder;

class UserPreferencesSeeder extends Seeder
{
    public function run(): void
    {


        $categories = Category::all()->pluck('id')->toArray();
        $sources = ['new-york-times', 'newsapi', 'guardian'];

        User::factory(10)->create(['password' => 'password'])->each(function ($user) use ($categories, $sources) {

            UserPreferences::create([
                'user_id' => $user->id,
                'category_ids' => [$categories[array_rand($categories)]],
                'sources' => [$sources[array_rand($sources)]],
            ]);
        });
    }

}
