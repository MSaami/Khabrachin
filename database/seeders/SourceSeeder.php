<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    const SOURCES = [

        'new-york-times',
        'bbc-news',
        'guardian',
    ];


    public function run(): void
    {
        foreach (self::SOURCES as $source) {
            DB::table('sources')->insert([
                'name' => $source
            ]);
        }
    }
}
