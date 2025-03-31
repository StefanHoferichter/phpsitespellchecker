<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            'title' => 'Hoferichter.net - Aspell',
            'sitemap' => 'https://www.hoferichter.net/sitemap.xml',
            'language_id' => '1',
            'tool_id' => '1',
        ]);
        DB::table('projects')->insert([
            'title' => 'Hoferichter.net - LanguageTool',
            'sitemap' => 'https://www.hoferichter.net/sitemap.xml',
            'language_id' => '1',
            'tool_id' => '2',
        ]);
    }
}
