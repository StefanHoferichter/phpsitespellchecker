<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            'short_name' => 'de',
            'long_name' => 'Deutsch',
        ]);
        DB::table('languages')->insert([
            'short_name' => 'en',
            'long_name' => 'English',
        ]);
    }
}
