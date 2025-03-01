<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    const CATEGORIES_NAME = [
        'sport',
        'arts',
        'entertainment',
        'world',
        'technology'
    ];


    public function run(): void
    {
        foreach (self::CATEGORIES_NAME as $name) {
            Category::firstOrCreate([
                'name' => $name
            ]);
        }
    }
}
