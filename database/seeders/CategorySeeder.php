<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    const CATEGORIES_NAME = [
        'sport',
        'arts',
        'entertainment',
        'politics',
    ];


    public function run(): void
    {
        foreach (self::CATEGORIES_NAME as $name) {
            DB::table('categories')->insert([
                'name' => $name
            ]);
        }
    }
}
